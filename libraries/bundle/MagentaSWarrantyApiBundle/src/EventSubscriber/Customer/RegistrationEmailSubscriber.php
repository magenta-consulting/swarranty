<?php

namespace Magenta\Bundle\SWarrantyApiBundle\EventSubscriber\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use Magenta\Bundle\SWarrantyApiBundle\Dto\Customer\RegistrationEmail;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\NewsletterSubscription;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class RegistrationEmailSubscriber implements EventSubscriberInterface {
	
	private $registry;
	private $mailer;
	
	public function __construct(RegistryInterface $registry, \Swift_Mailer $mailer) {
		$this->registry = $registry;
		$this->mailer   = $mailer;
	}
	
	public static function getSubscribedEvents() {
		return [
			KernelEvents::VIEW => [ 'onKernelView', EventPriorities::POST_VALIDATE ],
		
		];
	}
	
	public function onKernelView(GetResponseForControllerResultEvent $event) {
		$regEmail = $event->getControllerResult();
		$method   = $event->getRequest()->getMethod();
		
		$request = $event->getRequest();
		
		if( ! $regEmail instanceof RegistrationEmail || Request::METHOD_POST !== $method) {
			return;
		}
		
		$regRepo = $this->registry->getRepository(Registration::class);
		/** @var Registration $reg */
		$reg = $regRepo->find($regEmail->registrationId);
		
		// We do nothing if the Reg does not exist in the database
		if( ! empty($reg) && ! empty($email = $reg->getCustomer()->getEmail())) {
			$message = (new \Swift_Message('Hello Email'))
				->setFrom('no-reply@magenta-wellness.com')
				->setTo($email)
				->setBody(
					"<h1>Sample Email Template</h1>",
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
		if($regEmail->type === RegistrationEmail::TYPE_VERIFICATION) {
		
		}
		$event->setResponse(new JsonResponse([ 'message' => $message ], 201));
	}
	
}