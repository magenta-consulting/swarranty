<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
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

class WarrantyCaseAdminController extends BaseCRUDAdminController {
	
	protected function getDecision($action): ?string {
		$d = parent::getDecision($action);
		if(empty($d)) {
			$d = strtoupper($action);
		}
		
		return $d;
	}
	
	public function editAction($id = null) {
		$template = '@MagentaSWarrantyAdmin/Admin/Customer/WarrantyCase/CRUD/edit.html.twig';
		
		$this->admin->setTemplate('edit', $template);
		
		return parent::editAction($id);
	}
	
	public function listAction() {
		$this->admin->setTemplate('list', '@MagentaSWarrantyAdmin/Admin/Customer/WarrantyCase/CRUD/list.html.twig');
		
		return parent::listAction();
	}
	
	public function decideAction(
		$id = null, $action = 'show'
	) {
		$this->admin->setTemplate('decide', '@MagentaSWarrantyAdmin/Admin/Customer/WarrantyCase/CRUD/decide.html.twig');
		
		return parent::decideAction($id, $action);
	}
	
	protected function preRenderDecision($action, $object) {
		if($action !== 'show') {
			return $this->redirect($this->admin->generateObjectUrl('edit', $object, [  ]));
		}
	}
}