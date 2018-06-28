<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\Form\FormView;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class WarrantyAdminController extends BaseCRUDAdminController {
	
	public function listAction() {
		$this->admin->setTemplate('list', '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/CRUD/list.html.twig');
		
		return parent::listAction();
	}
	
	public function detailAction($id = null, Request $request) {
		$request = $this->getRequest();
		$id      = $request->get($this->admin->getIdParameter());
		/** @var Warranty $object */
		$object = $this->admin->getObject($id);
		
		if( ! $object) {
			throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
		}
		$customer = $object->getCustomer();
		$product  = $object->getProduct();
		$image    = $product->getImage();
		
		if(empty($image)) {
			$imageId = null;
			$afUrl   = $rfUrl = '/bundles/sonatamedia/grey.png';
		} else {
			$imageId = $image->getId();
			$afUrl   = $this->get('sonata.media.manager.media')->generatePrivateUrl($image->getId());
			$rfUrl   = $this->get('sonata.media.manager.media')->generatePrivateUrl($image->getId(), 'reference');
		}
		
		return new JsonResponse([
			'customer_name'  => $customer->getName(),
			'customer_phone' => '+' . $customer->getDialingCode() . ' ' . $customer->getTelephone(),
			'customer_email' => $customer->getEmail(),
			
			'customer_address' => $customer->getHomeAddress(),
			'customer_postal'  => $customer->getHomePostalCode(),
			
			'model_name'   => $product->getName(),
			'model_number' => $product->getModelNumber(),
			'brand'        => empty($product->getBrand()) ? '' : $product->getBrand()->getName(),
			'category'     => empty($product->getCategory()) ? '' : $product->getCategory()->getName(),
			
			'id'                       => $imageId,
			'admin_format'             => $afUrl,
			'reference_format'         => $rfUrl,
			'warranty_period'          => $product->getWarrantyPeriod(),
			'extended_warranty_period' => $product->getExtendedWarrantyPeriod()
		]);
	}
}