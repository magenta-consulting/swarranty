<?php

namespace Magenta\Bundle\SWarrantyApiBundle\EventSubscriber\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use Doctrine\ORM\EntityManagerInterface;
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
	private $mailer;
	private $manager;
	
	public function __construct(EntityManagerInterface $manager, RegistryInterface $registry, \Swift_Mailer $mailer) {
		$this->manager  = $manager;
		$this->registry = $registry;
		$this->mailer   = $mailer;
	}
	
	public static function getSubscribedEvents() {
		return [
			KernelEvents::REQUEST => [ 'onKernelRequest', EventPriorities::PRE_READ ],
			KernelEvents::VIEW    => [ 'onKernelView', EventPriorities::POST_WRITE ],
		
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
		
		$c = $reg->getCustomer();
		if( ! $reg->isVerified() && $c->isEmailVerified()) {
			$reg->setVerified(true);
			$this->manager->persist($reg);
			$this->manager->flush($reg);
		}
		
		if( ! $reg->isVerified() && ! empty($c) && ! empty($email = $c->getEmail()) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$msg     = $reg->prepareEmailVerificationMessage();
			$email   = $msg['recipient'];
			$customer = $reg->getCustomer();
			$message = (new \Swift_Message($msg['subject']))
				->setFrom('no-reply@' . $customer->getOrganisation()->getSystem()->getDomain())
				->setTo($email)
				->setBody(
					$msg['body'],
					'text/html'
				)/*
				 * If you also want to include a plaintext version of the message
				->addPart(
					$this->renderView(
						'emails/registration.txt.twig',
						array('name' => $name)
					),
					'text/plain'
				)
				*/
			;
			
			$this->mailer->send($message);
		}
	}
}