<?php

namespace Magenta\Bundle\SWarrantyApiBundle\EventSubscriber\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class CustomerSubscriber implements EventSubscriberInterface {
	
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
	
	}
	
	public function onKernelView(GetResponseForControllerResultEvent $event) {
		$customer = $event->getControllerResult();
		$method   = $event->getRequest()->getMethod();
		
		if( ! $customer instanceof Customer || Request::METHOD_POST !== $method) {
			return;
		}
		
		$cr        = $this->registry->getRepository(Customer::class);
		$customers = $cr->findBy([
			'telephone'   => $customer->getTelephone(),
			'dialingCode' => $customer->getDialingCode()
		]);
		
		if($cc = count($customers) === 0) {
			return;
		} elseif($cc === 1) {
			$event->setControllerResult($customers[0]);
		} else {
			$event->setControllerResult($customers[0]);
			/** @var Customer $c */
			foreach($customers as $c) {
				if($c->getEmail() === $customer->getEmail()) {
					$event->setControllerResult($c);
					
					return;
				}
			}
		}
	}
	
}