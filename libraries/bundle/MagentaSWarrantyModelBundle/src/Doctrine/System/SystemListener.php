<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\System;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\System;
use Psr\Container\ContainerInterface;

class SystemListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfoAfterOperation(System $system, LifecycleEventArgs $event) {
		$this->updateInfo($system, $event);
		$manager  = $event->getEntityManager();
		$registry = $this->container->get('doctrine');
	}
	
	private function updateInfo(System $system, LifecycleEventArgs $event) {
	}
	
	private function updateInfoBeforeOperation(System $system, LifecycleEventArgs $event) {
		$this->updateInfo($system, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
		$systemRepo = $registry->getRepository(System::class);
		
		$uow = $manager->getUnitOfWork();
		
	}
	
	public function preFlushHandler(System $system, PreFlushEventArgs $event) {
		$manager  = $event->getEntityManager();
		$registry = $this->container->get('doctrine');
		$orgs     = $system->getOrganisations();
		
		$qb = $manager->createQueryBuilder();
		$qb->select('w')->from(Warranty::class, 'w');
		$wResult = $qb->getQuery()->getResult();
		
		/** @var Organisation $org */
		foreach($orgs as $org) {
			$org->prepareNewRegistrationMessage([ 'total' => [ 'new' => count($wResult) ] ]);
		}
	}
	
	public function preUpdateHandler(System $system, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($system, $event);
	}
	
	public function postUpdateHandler(System $system, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($system, $event);
	}
	
	public function prePersistHandler(System $system, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($system, $event);
		
	}
	
	public function postPersistHandler(System $system, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($system, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
	}
	
	public function preRemoveHandler(System $system, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(System $system, LifecycleEventArgs $event) {
	}
}