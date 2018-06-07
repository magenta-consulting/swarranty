<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
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

class ACLAdminController extends BaseCRUDAdminController {
	
	public function setACEntryAction($id, $code, $permission, $action = 'enable', Request $request) {
//		$request = $this->getRequest();
		$id = $request->get($this->admin->getIdParameter());
		
		$object = $this->admin->getObject($id);
		
		if( ! $object) {
			throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
		}
		
		$this->admin->checkAccess('show', $object);
		
		return new JsonResponse([ sprintf('hello %s %s %s %s', $id, $code, $permission, $action) ]);
	}
}