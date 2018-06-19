<?php

namespace Magenta\Bundle\SWarrantyApiBundle\EventSubscriber\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\NewsletterSubscription;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class NewsletterSubscriptionSubscriber implements EventSubscriberInterface {
	
	private $registry;
	
	public function __construct(RegistryInterface $registry) {
		$this->registry = $registry;
	}
	
	public static function getSubscribedEvents() {
		return [
			KernelEvents::VIEW    => [ 'onKernelView', EventPriorities::PRE_WRITE ],
		
		];
	}
	
	
	public function onKernelView(GetResponseForControllerResultEvent $event) {
		$nls = $event->getControllerResult();
		$method   = $event->getRequest()->getMethod();
		
		if( ! $nls instanceof NewsletterSubscription || Request::METHOD_POST !== $method) {
			return;
		}
		
		$nr        = $this->registry->getRepository(NewsletterSubscription::class);
		$nlsResults = $nr->findBy([
			'email'   => $nls->getEmail()
		]);
		
		if($cc = count($nlsResults) === 0) {
			return;
		} elseif($cc === 1) {
			$event->setControllerResult($nlsResults[0]);
		} else {
			$event->setControllerResult($nlsResults[0]);
			/** @var NewsletterSubscription $c */
			foreach($nlsResults as $c) {
				if($c->getEmail() === $nls->getEmail()) {
					$event->setControllerResult($c);
					
					return;
				}
			}
		}
	}
	
}