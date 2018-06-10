<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\Event\LifecycleEventArgs;
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
	
	private function updateInfo(Warranty $warranty) {
	
	}
	
	public function preUpdateHandler(Warranty $warranty, LifecycleEventArgs $event) {
		$this->updateInfo($warranty);
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
//		$this->handleAdminEmail($warranty);
	}
	
	public function prePersistHandler(Warranty $warranty, LifecycleEventArgs $event) {
		$this->updateInfo($warranty);
		$expiryAt = $warranty->getCreatedAt();
		$expiryAt->modify(sprintf("+%d months", $warranty->getProduct()->getWarrantyPeriod()));
		$warranty->setExpiryDate($expiryAt);
	}
	
	public function postPersistHandler(Warranty $warranty, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($warranty);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(Warranty $warranty, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Warranty $warranty, LifecycleEventArgs $event) {
	}
	
}