<?php

namespace Magenta\Bundle\SWarrantyApiBundle\EventSubscriber\Organisation;

use ApiPlatform\Core\EventListener\EventPriorities;
use ApiPlatform\Core\Util\RequestParser;
use Magenta\Bundle\SWarrantyJWTBundle\Security\JWTUser;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class OrganisationMemberSubscriber implements EventSubscriberInterface {
	
	private $registry;
	private $userService;
	
	public function __construct(UserService $us, RegistryInterface $registry) {
		$this->registry    = $registry;
		$this->userService = $us;
	}
	
	public static function getSubscribedEvents() {
		return [
			KernelEvents::REQUEST => [ 'filterData', EventPriorities::PRE_READ ],
			KernelEvents::VIEW    => [ 'onKernelView', EventPriorities::PRE_WRITE ],
		
		];
	}
	
	/**
	 * Calls the data provider and sets the data attribute.
	 *
	 * @param GetResponseEvent $event
	 *
	 * @throws NotFoundHttpException
	 */
	public function filterData(GetResponseEvent $event) {
		$request    = $event->getRequest();
		$class      = $request->attributes->get('_api_resource_class');
		$controller = $request->attributes->get('_controller');
		if($request->isMethod('get') && $class === OrganisationMember::class && $controller === 'api_platform.action.get_collection') {
//			$rs = $this->recruiterService;
			$orgRepo = $this->registry->getRepository(Organisation::class);
			/** @var JWTUser $user */
			$user = $this->userService->getUser();
			if(in_array(User::ROLE_ADMIN, $user->getRoles())) {
				return;
			}
			$userRepo = $this->registry->getRepository(User::class);
			/** @var User $_user */
			$_user = $userRepo->findOneBy([ 'username' => $user->getUsername() ]);
			if(empty($_user)) {
				throw new AccessDeniedException($user->getUsername() . ' is not found');
			}
			if(empty($orgId = $request->query->getInt('organization', 0))) {
				throw new AccessDeniedException('No Organisation specified');
			}
			$org = $orgRepo->find($orgId);
			if(empty($org)) {
				throw new AccessDeniedException('Unknown Organisation');
			}
			$person = $_user->getPerson();
			if(empty($person)) {
				throw new AccessDeniedException('Your account does not have any profile');
			}
			$mem = $person->getMemberOfOrganisation($org);
			
			if(empty($mem)) {
				throw new AccessDeniedException('No membership found for this organisation');
			}
			
			$memId = $mem->getId() . '';
//
//			$request->query->set('id', $memId);
			$queryString = RequestParser::getQueryString($request);
			$filters     = $queryString ? RequestParser::parseRequestParams($queryString) : null;
			$idFilter    = [ 'id' => $memId ];
			$filters     = null === $filters ? $idFilter : array_merge($filters, $idFilter);
			$request->attributes->set('_api_filters', $filters);
//
//			var_dump($request->attributes);exit();
		}
		
	}
	
	public function onKernelView(GetResponseForControllerResultEvent $event) {
	
	}
	
}