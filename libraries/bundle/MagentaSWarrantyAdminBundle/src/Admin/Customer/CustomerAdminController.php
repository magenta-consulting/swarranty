<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\SpreadsheetWriter;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormView;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class CustomerAdminController extends BaseCRUDAdminController {
	
	public function listAction() {
		
		return parent::listAction();
	}
	
	/**
	 * Export data to specified format.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 *
	 * @throws AccessDeniedException If access is not granted
	 * @throws \RuntimeException     If the export format is invalid
	 */
	public function exportAction(Request $request) {
		/**
		 * @var ContainerInterface $c
		 */
		$c = $this->container;

//		$this->admin->checkAccess('export');
		$format = $request->get('format');
		
		$adminExporter        = $this->get('sonata.admin.admin_exporter');
		$allowedExportFormats = array_merge($adminExporter->getAvailableFormats($this->admin), [ 'html' ]);
//		$filename             = $adminExporter->getExportFilename($this->admin, $format);
//		$exporter             = $this->get('sonata.exporter.exporter');
		
		
		if( ! in_array($format, $allowedExportFormats)) {
			throw new \RuntimeException(
				sprintf(
					'Export in format `%s` is not allowed for class: `%s`. Allowed formats are: `%s`',
					$format,
					$this->admin->getClass(),
					implode(', ', $allowedExportFormats)
				)
			);
		}
		
		if($format === 'xls') {
			$format = 'xlsx';
		}
		$filename = sprintf(
			'export_%s_%s.%s',
			strtolower(substr($this->admin->getClass(), strripos($this->admin->getClass(), '\\') + 1)),
			date('Y_m_d_H_i_s', strtotime('now')),
			$format
		);
		
		if($format === 'html') {
			$d = new \DateTime();
			
			$source    = $this->admin->getDataSourceIterator();
			$customers = [];
			/** @var array of WarrantyCase $customer */
			foreach($source as $customer) {
				$customers[] = $customer['id'];
			}
			
			$htmlDisplayUrl = $c->get('router')->generate('service_sheet', [
				'cases' => $customers
			], RouterInterface::ABSOLUTE_URL);
			$response       = new RedirectResponse($c->getParameter('PDF_API_BASE_URL') . $c->getParameter('PDF_DOWNLOAD_PREFIX') . str_replace('?', '%3F', $htmlDisplayUrl) . '/' . 'service-sheets_' . $d->format('d-m-Y'));
			
			return $response;
		} else if($format === 'xlsx') {
			// ask the service for a Excel5
			$phpExcelObject = new Spreadsheet();
			
			$phpExcelObject->getProperties()->setCreator("Solution")
			               ->setLastModifiedBy("Solution")
			               ->setTitle("Download - Raw Data")
			               ->setSubject("Order Item - Raw Data")
			               ->setDescription("Raw Data")
			               ->setKeywords("office 2005 openxml php")
			               ->setCategory("Raw Data Download");
			
			$phpExcelObject->setActiveSheetIndex(0);
			$activeSheet = $phpExcelObject->getActiveSheet();
			
			$activeSheet
				->setCellValue('A1', "ID")
				->setCellValue('B1', "Name")
				->setCellValue('C1', "Email")
				->setCellValue('D1', "Contact Number")
				->setCellValue('E1', "Address")
				->setCellValue('F1', "Age Group")
				->setCellValue('G1', "Know from")
				->setCellValue('H1', "Reasons to choose FUJIOH")
//				->setCellValue('I1', "Case Description")
//				->setCellValue('J1', "Service Notes")
//				->setCellValue('K1', "Special Notes")
//				->setCellValue('L1', "Technicians")
//				->setCellValue('M1', "Service Zones")
//				->setCellValue('N1', "Customer Name")//			            ->setCellValue('O1', "Technician Name(s)")
			;
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$phpExcelObject->setActiveSheetIndex(0);
			$activeSheet = $phpExcelObject->getActiveSheet();
			$sWriter     = new SpreadsheetWriter($activeSheet);
			$sWriter->goFirstColumn();
			$sWriter->goFirstRow();
			
			$source = $this->admin->getDataSourceIterator();
			$repo   = $this->getDoctrine()->getRepository(Customer::class);
			foreach($source as $data) {
				$customer = $repo->find($data['id']);
				$sWriter->goDown();
				$sWriter->goFirstColumn();
				
				$sWriter->writeCellAndGoRight($customer->getId());
				// Number
				$sWriter->writeCellAndGoRight($customer->getName());
				$sWriter->writeCellAndGoRight($customer->getEmail());
				$sWriter->writeCellAndGoRight($customer->getTelephone());
				$sWriter->writeCellAndGoRight($customer->getHomeAddress());
				
				$ageGroup = '';
				/** @var Registration $reg */
				$reg = $customer->getRegistrations()->last();
				if( ! empty($reg)) {
					$ageGroup = $reg->getAgeGroup();
					$hfOnlineSearch = $reg->getHearFromOnlineSearch();
					$hfOnlineAd = $reg->getHearFromOnlineAd();
					$hfOnlineFF = $reg->getHearFromFriendFamily();
//					$hfOnlineAd = $reg->getHearFrom;
				}
				$closedAtStr = '';
				if( ! empty($customer->getClosedAt())) {
					$closedAtStr = $customer->getClosedAt()->format('d-m-Y');
				}
				$sWriter->writeCellAndGoRight($closedAtStr);
				$brand        = '';
				$category     = '';
				$modelName    = '';
				$zoneStr      = '';
				$customerName = '';
				/** @var Warranty $w */
				if( ! empty($w = $customer->getWarranty())) {
					/** @var Product $p */
					if( ! empty($p = $w->getProduct())) {
						/** @var Brand $b */
						if( ! empty($b = $p->getBrand())) {
							$brand = $b->getName();
						}
						if( ! empty($c = $p->getCategory())) {
							$category = $c->getName();
						}
						$modelName = $p->getName();
					}
					
					if( ! empty($customer = $w->getCustomer())) {
						$customerName = $customer->getName();
					}
				}
				
				/** @var ServiceZone $zone */
				if( ! empty($zone = $customer->getServiceZone())) {
					$zoneStr = $zone->getName();
				}
				
				$sWriter->writeCellAndGoRight($brand);
				$sWriter->writeCellAndGoRight($category);
				$sWriter->writeCellAndGoRight($modelName);
				$sWriter->writeCellAndGoRight($customer->getDescription());
				$sWriter->writeCellAndGoRight($customer->getServiceNotesString());
				$sWriter->writeCellAndGoRight($customer->getSpecialRemarks());
				$sWriter->writeCellAndGoRight($customer->getAssigneeString());
				$sWriter->writeCellAndGoRight($zoneStr);
				$sWriter->writeCellAndGoRight($customerName);
				
			}
			
			// create the writer
			$writer = new Xlsx($phpExcelObject);
//			$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
			// create the response
//			$response = $this->get('phpexcel')->createStreamedResponse($writer);
			$response = new StreamedResponse(
				function() use ($writer) {
					$writer->save('php://output');
				},
				200,
				[]
			);
			
			$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
			$response->headers->set('Pragma', 'public');
			$response->headers->set('Cache-Control', 'maxage=1');
			
			$response->headers->set('Content-Disposition', 'attachment;filename=' . $filename);
			
			return $response;
		}
		
		return parent::exportAction($request);
	}
}
