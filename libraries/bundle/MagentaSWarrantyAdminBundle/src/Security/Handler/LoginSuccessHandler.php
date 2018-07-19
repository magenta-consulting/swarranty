<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Security\Handler;


use Doctrine\ORM\EntityManagerInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {
	/**
	 * @var null|EntityManagerInterface
	 */
	private $manager;
	private $router;
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->router    = $container->get('router');
		$this->manager   = $container->get('doctrine.orm.default_entity_manager');
		$this->container = $container;
	}
	
	/**
	 * This is called when an interactive authentication attempt succeeds. This
	 * is called by authentication listeners inheriting from
	 * AbstractAuthenticationListener.
	 *
	 * @param Request        $request
	 * @param TokenInterface $token
	 *
	 * @return Response never null
	 */
	public
	function onAuthenticationSuccess(
		Request $request, TokenInterface $token
	) {
		/** @var User $user */
		$user    = $token->getUser();
		$url     = $this->router->generate('sonata_admin_dashboard');
		$session = $this->container->get('session');
		$key     = '_security.admin.target_path'; #where "main" is your firewall name
		$orgRepo = $this->container->get('doctrine')->getRepository(Organisation::class);
		$org     = $orgRepo->find(1);
		
		if($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN')) {
			$url = $this->router->generate('admin_magenta_swarrantymodel_organisation_organisation_list', []);

//check if the referrer session key has been set
		} elseif( ! empty($org) && ($user->getAdminOrganisation() === $org) || ! empty($p = $user->getPerson()) && ! empty($m = $p->getMemberOfOrganisation($org))) {
			$url = $this->router->generate('admin_magenta_swarrantymodel_customer_warranty_list', []);
		}
		
		if($session->has($key)) {
			//set the url based on the link they were trying to access before being authenticated
			$url = $this->container->get('session')->get($key);
			
			//remove the session key
			$session->remove($key);
		}
		$response = new RedirectResponse($url);
		
		return $response;
	}
}