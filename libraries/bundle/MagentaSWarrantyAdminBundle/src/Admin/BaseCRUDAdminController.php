<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin;

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

class BaseCRUDAdminController extends CRUDController {
	
	/**
	 * Show action.
	 *
	 * @param int|string|null $id
	 *
	 * @throws NotFoundHttpException If the object does not exist
	 * @throws AccessDeniedException If access is not granted
	 *
	 * @return Response
	 */
	public function decideAction($id = null, $action) {
		$request = $this->getRequest();
		$id      = $request->get($this->admin->getIdParameter());
		
		$object = $this->admin->getObject($id);
		
		if( ! $object) {
			throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
		}
		
		$this->admin->checkAccess($action, $object);
		
		$preResponse = $this->preShow($request, $object);
		if(null !== $preResponse) {
			return $preResponse;
		}
		
		$this->admin->setSubject($object);
		
		// NEXT_MAJOR: Remove this line and use commented line below it instead
		$template = $this->admin->getTemplate('decide');

//		$template = $this->templateRegistry->getTemplate('show');
		
		return $this->renderWithExtraParams($template, [
			'action'   => $action,
			'object'   => $object,
			'elements' => $this->admin->getShow(),
		], null);
	}
	
	protected function getRefererParams() {
		$request = $this->getRequest();
		$referer = $request->headers->get('referer');
		$baseUrl = $request->getBaseUrl();
		if(empty($baseUrl)) {
			return null;
		}
		$lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
		
		return $this->get('router')->match($lastPath);
//		getMatcher()
	}
	
	protected function isAdmin() {
		return $this->get(UserService::class)->getUser()->isAdmin();
	}
	
	/**
	 * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
	 *
	 * @param FormView $formView
	 * @param string   $theme
	 */
	protected function setFormTheme(FormView $formView, $theme) {
		$twig = $this->get('twig');
		
		try {
			$twig
				->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')
				->setTheme($formView, $theme);
		} catch(\Twig_Error_Runtime $e) {
			// BC for Symfony < 3.2 where this runtime not exists
			$twig
				->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')
				->renderer
				->setTheme($formView, $theme);
		}
	}
	
}