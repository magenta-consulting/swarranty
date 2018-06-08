<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Product;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSubCategory;
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

class BrandSubCategoryAdminController extends BaseCRUDAdminController {
	
	public function crudAction($id = null, $operation, Request $request) {
		$manager   = $this->getDoctrine()->getManager();
		$operation = strtoupper($operation);
		if($operation !== 'CREATE') {
			$id = $request->get($this->admin->getIdParameter());
			/** @var BrandSubCategory $cat */
			$cat = $this->admin->getObject($id);
			if( ! $cat) {
				throw $this->createNotFoundException(sprintf('unable to find the Sub-Category with id: %s', $id));
			}
			if($operation === 'UPDATE') {
				$this->admin->checkAccess('edit', $cat);
				$name = $request->get('name');
				$cat->setName($name);
				$manager->persist($cat);
				$manager->flush();
				
				return new JsonResponse([
					'status'     => 204,
					'id'         => $cat->getId(),
					'name'       => $cat->getName(),
					'admin_code' => $this->admin->getCode()
				]);
			}
			if($operation === 'DELETE') {
				$this->admin->checkAccess('delete', $cat);
				$catId   = $cat->getId();
				$catName = $cat->getName();
				$manager->remove($cat);
				$manager->flush();
				
				return new JsonResponse([
					'status'     => 200,
					'id'         => $catId,
					'name'       => $catName,
					'admin_code' => $this->admin->getCode()
				]);
			}
			
		} else {
			$this->admin->checkAccess('create');
			$name = $request->get('name');
			$cat  = new BrandSubCategory();
			$cat->setEnabled(true);
			$cat->setName($name);
			$org = $this->admin->getParent()->getSubject();
			$cat->setOrganisation($org);
			
			$manager->persist($cat);
			$manager->flush();
			
			return new JsonResponse([
				'status'     => 201,
				'id'         => $cat->getId(),
				'name'       => $cat->getName(),
				'admin_code' => $this->admin->getCode()
			]);
		}
		
		
		return new JsonResponse([ sprintf('hello %s', $id) ]);
	}
}