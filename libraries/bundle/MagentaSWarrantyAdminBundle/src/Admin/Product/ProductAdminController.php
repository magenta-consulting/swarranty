<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Product;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\Form\FormView;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class ProductAdminController extends BaseCRUDAdminController {
	
	public function detailAction($id = null, Request $request) {
		$request = $this->getRequest();
		$id      = $request->get($this->admin->getIdParameter());
		/** @var Product $object */
		$object = $this->admin->getObject($id);
		
		if( ! $object) {
			throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
		}
		
		$image = $object->getImage();
		if(empty($image)) {
			$imageId = null;
			$afUrl   = $rfUrl = '/bundles/sonatamedia/grey.png';
		} else {
			$imageId = $image->getId();
			$afUrl   = $this->get('sonata.media.manager.media')->generatePrivateUrl($image->getId());
			$rfUrl   = $this->get('sonata.media.manager.media')->generatePrivateUrl($image->getId(), 'reference');
		}
		$wp = $object->getWarrantyPeriod();
		if(empty($wp)) {
			$wp = '';
		}
		$ewp = $object->getExtendedWarrantyPeriod();
		if(empty($ewp)) {
			$ewp = '';
		}
		return new JsonResponse([
			'id_image'                 => $imageId,
			'admin_format'             => $afUrl,
			'reference_format'         => $rfUrl,
			'warranty_period'          => $wp,
			'extended_warranty_period' => $ewp
		]);
	}
}