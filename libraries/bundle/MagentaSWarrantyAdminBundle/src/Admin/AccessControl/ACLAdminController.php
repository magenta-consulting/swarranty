<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole;
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
		$code = strtoupper($code);
		
		$id = $request->get($this->admin->getIdParameter());
		
		/** @var ACRole $role */
		$role = $this->admin->getObject($id);
		
		if( ! $role) {
			throw $this->createNotFoundException(sprintf('unable to find the Role with id: %s', $id));
		}
		
		$this->admin->checkAccess('edit', $role);
		
		$manager = $this->getDoctrine()->getManager();
		
		if($action === 'enable') {
			$manager->persist($role->grantPermission($permission, $code));
			$manager->flush();
			
			return new JsonResponse([ 'OK' ]);
		} elseif($action === 'remove') {
			if( ! empty($entry = $role->getEntryByModuleCode($permission, $code))) {
				$manager->remove($entry);
				$manager->flush();
			}
			
			return new JsonResponse([ 'OK' ]);
		} elseif($action === 'status') {
			$status = $role->getEntryStatus($permission, $code);
			
			return new JsonResponse([ 'status' => $status ]);
		}
		
		return new JsonResponse([ sprintf('hello %s %s %s %s', $id, $code, $permission, $action) ]);
	}
}