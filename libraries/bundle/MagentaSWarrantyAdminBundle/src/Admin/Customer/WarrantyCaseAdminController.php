<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
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

class WarrantyCaseAdminController extends BaseCRUDAdminController {
	
	public function listAction() {
		$this->admin->setTemplate('base_list', '@MagentaSWarrantyAdmin/Admin/Customer/WarrantyCase/CRUD/list.html.twig');
		$this->admin->setTemplate('base_list_field', '@MagentaSWarrantyAdmin/Admin/Customer/WarrantyCase/CRUD/list_field.html.twig');
		
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
			
			$source = $this->admin->getDataSourceIterator();
			$cases  = [];
			/** @var array of WarrantyCase $case */
			foreach($source as $case) {
				$cases[] = $case['id'];
			}
			
			$htmlDisplayUrl = $c->get('router')->generate('service_sheet', [
				'cases' => $cases
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
				->setCellValue('B1', "Number")
				->setCellValue('C1', "Priority")
				->setCellValue('D1', "Date Created")
				->setCellValue('E1', "Date Closed")
				->setCellValue('F1', "Product Brand")
				->setCellValue('G1', "Product Category")
				->setCellValue('H1', "Product Model Name")
				->setCellValue('I1', "Case Description")
				->setCellValue('J1', "Service Notes")
				->setCellValue('K1', "Special Notes")
				->setCellValue('L1', "Technicians")
				->setCellValue('M1', "Service Zones")
				->setCellValue('N1', "Customer Name")//			            ->setCellValue('O1', "Technician Name(s)")
			;
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$phpExcelObject->setActiveSheetIndex(0);
			$activeSheet = $phpExcelObject->getActiveSheet();
			$sWriter     = new SpreadsheetWriter($activeSheet);
			$sWriter->goFirstColumn();
			$sWriter->goFirstRow();
			
			$source = $this->admin->getDataSourceIterator();
			$repo   = $this->getDoctrine()->getRepository(WarrantyCase::class);
			foreach($source as $data) {
				$case = $repo->find($data['id']);
				$sWriter->goDown();
				$sWriter->goFirstColumn();
				
				$sWriter->writeCellAndGoRight($case->getId());
				// Number
				$sWriter->writeCellAndGoRight($case->getNumber());
				$sWriter->writeCellAndGoRight($case->getPriority());
				$sWriter->writeCellAndGoRight($case->getCreatedAt()->format('d-m-Y'));
				$closedAtStr = '';
				if( ! empty($case->getClosedAt())) {
					$closedAtStr = $case->getClosedAt()->format('d-m-Y');
				}
				$sWriter->writeCellAndGoRight($closedAtStr);
				$brand        = '';
				$category     = '';
				$modelName    = '';
				$zoneStr      = '';
				$customerName = '';
				/** @var Warranty $w */
				if( ! empty($w = $case->getWarranty())) {
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
				if( ! empty($zone = $case->getServiceZone())) {
					$zoneStr = $zone->getName();
				}
				
				$sWriter->writeCellAndGoRight($brand);
				$sWriter->writeCellAndGoRight($category);
				$sWriter->writeCellAndGoRight($modelName);
				$sWriter->writeCellAndGoRight($case->getDescription());
				$sWriter->writeCellAndGoRight($case->getServiceNotesString());
				$sWriter->writeCellAndGoRight($case->getSpecialRemarks());
				$sWriter->writeCellAndGoRight($case->getAssigneeString());
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
	
	protected
	function getDecision(
		$action
	): ?string {
		$d = parent::getDecision($action);
		if(empty($d)) {
			$d = strtoupper($action);
		}
		
		return $d;
	}
	
	protected
	function preRenderDecision(
		$action, $object
	) {
		if($action !== 'show') {
			return $this->redirect($this->admin->generateObjectUrl('edit', $object, []));
		}
	}
}
