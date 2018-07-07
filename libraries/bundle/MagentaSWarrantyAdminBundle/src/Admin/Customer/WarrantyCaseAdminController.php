<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class WarrantyCaseAdminController extends BaseCRUDAdminController {
	
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
		$allowedExportFormats = $adminExporter->getAvailableFormats($this->admin);
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
		
		$filename = sprintf(
			'export_%s_%s.%s',
			strtolower(substr($this->admin->getClass(), strripos($this->admin->getClass(), '\\') + 1)),
			date('Y_m_d_H_i_s', strtotime('now')),
			$format
		);
		
		if($format === 'html') {
//			$spreadsheet = new Spreadsheet();
//			$sheet       = $spreadsheet->getActiveSheet();
//			$sheet->setCellValue('A1', 'Hello World !');
//
//			$writer   = new Xlsx($spreadsheet);
//			$filename = 'service-sheet.xlsx';

//			// ask the service for a Excel5
//			$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
//
//			$phpExcelObject->getProperties()->setCreator("Solution")
//			               ->setLastModifiedBy("Solution")
//			               ->setTitle("Download - Raw Data")
//			               ->setSubject("Employee Report - Raw Data")
//			               ->setDescription("Raw Data")
//			               ->setKeywords("office 2005 openxml php")
//			               ->setCategory("Raw Data Download");
//
//			$phpExcelObject->setActiveSheetIndex(0);
//			$activeSheet = $phpExcelObject->getActiveSheet();
//
//			$activeSheet->setCellValue('A1', "First Name")
//			            ->setCellValue('B1', "Last Name")
//			            ->setCellValue('C1', "DOB")
//			            ->setCellValue('D1', "Gender")
//			            ->setCellValue('E1', "NRIC/FIN")
//			            ->setCellValue('F1', "SchemeID")
//			            ->setCellValue('G1', "Employer")
//			            ->setCellValue('H1', "Biz Registration No");
//
//			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//			$phpExcelObject->setActiveSheetIndex(0);
//			$activeSheet = $phpExcelObject->getActiveSheet();
//			$sWriter = new SpreadsheetWriter($activeSheet);
//			$sWriter->goFirstColumn();
//			$sWriter->goFirstRow();
//
//			$source = $this->admin->getDataSourceIterator();
//			foreach ($source as $data) {
//				$sWriter->goDown();
//				$sWriter->goFirstColumn();
//				foreach ($data as $value) {
//					$sWriter->writeCell($value);
//					$sWriter->goRight();
//				}
//			}
//
//			// create the writer
//			$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
			
			// create the response
//			$response = $this->createSpreadsheetStreamedResponse($writer);
//			$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
//			$response->headers->set('Pragma', 'public');
//			$response->headers->set('Cache-Control', 'maxage=1');
//
//			$response->headers->set('Content-Disposition', 'attachment;filename=' . $filename);
			$d = new \DateTime();
			
			$source = $this->admin->getDataSourceIterator();
			$cases  = [];
			/** @var WarrantyCase $case */
			foreach($source as $case) {
				$cases[] = $case->getId();
			}
			
			$htmlDisplayUrl = $c->get('router')->generate('service_sheet', [
				'cases' => $cases
			], RouterInterface::ABSOLUTE_URL);
			$response       = new RedirectResponse($c->getParameter('PDF_API_BASE_URL') . $c->getParameter('PDF_DOWNLOAD_PREFIX') . str_replace('?', '%3F', $htmlDisplayUrl) . '/' . 'service-sheets_' . $d->format('d-m-Y'));
			
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