<?php

namespace Magenta\Bundle\SWarrantyApiBundle\EventSubscriber\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class RegistrationSubscriber implements EventSubscriberInterface {
	
	private $registry;
	
	public function __construct(RegistryInterface $registry) {
		$this->registry = $registry;
	}
	
	public static function getSubscribedEvents() {
		return [
			KernelEvents::REQUEST => [ 'onKernelRequest', EventPriorities::PRE_READ ],
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
	public function onKernelRequest(GetResponseEvent $event) {
		$request    = $event->getRequest();
		$class      = $request->attributes->get('_api_resource_class');
		$controller = $request->attributes->get('_controller');
		if($request->isMethod('get') && $class === Registration::class && $controller === 'api_platform.action.get_item') {
		
		}
	}
	
	public function onKernelView(GetResponseForControllerResultEvent $event) {
		$reg    = $event->getControllerResult();
		$method = $event->getRequest()->getMethod();
		
		if( ! $reg instanceof Registration || Request::METHOD_POST !== $method) {
			return;
		}
		
		$nr         = $this->registry->getRepository(Registration::class);
		$org        = $reg->getOrganisation();
		$mt         = $org->getMessageTemplateByType(MessageTemplate::TYPE_REGISTRATION_VERIFICATION);
		
		$nlsResults = $nr->findBy([
			'email' => $nls->getEmail()
		]);
		
		if($cc = count($nlsResults) === 0) {
			return;
		} elseif($cc === 1) {
			$event->setControllerResult($nlsResults[0]);
		} else {
			$event->setControllerResult($nlsResults[0]);
			/** @var Registration $c */
			foreach($nlsResults as $c) {
				if($c->getEmail() === $nls->getEmail()) {
					$event->setControllerResult($c);
					
					return;
				}
			}
		}
	}
	
}