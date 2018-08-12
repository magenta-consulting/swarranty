<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WarrantyListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfoAfterOperation(Warranty $warranty, LifecycleEventArgs $event) {
		$warranty->generateSearchText();
		$warranty->generateFullText();
		$manager   = $event->getEntityManager();
		$uow       = $manager->getUnitOfWork();
		$customer  = $warranty->getCustomer();
		$cr        = $this->container->get('doctrine')->getRepository(Customer::class);
		$customers = $cr->findBy([
			'telephone'    => $customer->getTelephone(),
			'dialingCode'  => $customer->getDialingCode(),
			'organisation' => $customer->getOrganisation()
		]);
		
		return;
		if($cc = count($customers) === 0) {
			return;
		} elseif($cc === 1) {
			$customer->removeWarranties($warranty);
//			$customers[0]->addWarranties($warranty);
			$warranty->setCustomer($customers[0]);
			$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Warranty::class), $warranty);
		} else {
			$customer->removeWarranties($warranty);
//			$customers[0]->addWarranties($warranty);
			$warranty->setCustomer($customers[0]);
			$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Warranty::class), $warranty);
			/** @var Customer $c */
			foreach($customers as $c) {
				if($c->getEmail() === $customer->getEmail()) {
					$customer->removeWarranties($warranty);
//					$c->addWarranties($warranty);
					$warranty->setCustomer($c);
					$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Warranty::class), $warranty);
					
					return;
				}
			}
		}
		
		
	}
	
	public function preUpdateHandler(Warranty $warranty, LifecycleEventArgs $event) {

//		if( ! empty($warranty->getRegNo())) {
//			$warranty->setRegNo(strtoupper($warranty->getRegNo()));
//		}

//		if(empty($warranty->getName())) {
//			$warranty->setName($warranty->getRegNo());
//		}
//		$warranty->setSlug($this->container->get('bean_core.string')->slugify($warranty->getName()));

//		if(empty($warranty->getCode())) {
//			if( ! empty($warranty->getRegNo())) {
//				$warranty->setCode($warranty->getRegNo());
//			} else {
//				$warranty->setCode($warranty->getSlug());
//			}
//		}
//		$warranty->setCode(strtoupper(trim($warranty->getCode())));
	}
	
	public function postUpdateHandler(Warranty $warranty, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($warranty, $event);
	}
	
	public function prePersistHandler(Warranty $warranty, LifecycleEventArgs $event) {
		if(empty($warranty->getExpiryDate())) {
			$expiryAt = clone $warranty->getPurchaseDate();
			$expiryAt->modify(sprintf("+%d months", $warranty->getProduct()->getWarrantyPeriod()));
			if( ! empty($warranty->getRegistration())) {
				$expiryAt->modify(sprintf("+%d months", $warranty->getExtendedWarrantyPeriod()));
			}
			$warranty->setExpiryDate($expiryAt);
		}
		if( ! empty($reg = $warranty->getRegistration())) {
			$warranty->setCustomer($reg->getCustomer());
		}
	}
	
	public function postPersistHandler(Warranty $warranty, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($warranty, $event);
//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(Warranty $warranty, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Warranty $warranty, LifecycleEventArgs $event) {
	}
	
	public function preFlushHandler(Warranty $warranty, PreFlushEventArgs $event) {
		$manager  = $event->getEntityManager();
		$registry = $this->container->get('doctrine');
		
	}
	
	public function postLoadHandler(Warranty $warranty, LifecycleEventArgs $args) {
		if(empty($warranty->getNumber())) {
			$warranty->initiateNumber();
			$warranty->generateSearchText();
			$warranty->generateFullText();
			$manager = $args->getEntityManager();
//			$manager->persist($warranty);
//			$manager->flush($warranty);
			$manager->persist($warranty);
			$manager->flush($warranty);
		}
		
		if($warranty->isApproved() && ! $warranty->isWarrantyApprovalNotified()) {
			$customer = $warranty->getCustomer();
			if(filter_var($customer->getEmail(), FILTER_VALIDATE_EMAIL)) {
				$warranty->setWarrantyApprovalNotified(true);
				$msg   = $warranty->prepareWarrantyApprovedNotifMessage();
				$email = $msg['recipient'];
				
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
				
				$this->container->get('mailer')->send($message);
				
				$manager = $args->getEntityManager();
				$manager->persist($warranty);
				$manager->flush($warranty);
			}
		}
		
	}
}