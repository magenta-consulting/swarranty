<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Organisation;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrganisationMemberListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfAfterFlush(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfo($member, $event);
		$manager = $event->getEntityManager();
		$manager->flush();
	}
	
	private function updateInfo(OrganisationMember $member, LifecycleEventArgs $event) {
		/** @var EntityManager $manager */
		$manager = $event->getObjectManager();
		$uow     = $manager->getUnitOfWork();
		$user    = $this->container->get(UserService::class)->getUser();
		/** @var Person $person */
		$person = $member->getPerson();
		if(empty($person->getId())) {
		
		}
		$email = $person->getEmail();
		if(empty($pu = $person->getUser())) {
		
		}
	}
	
	public function preUpdateHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		
	}
	
	public function postUpdateHandler(OrganisationMember $member, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($member);
	}
	
	public function prePersistHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		
	}
	
	public function postPersistHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		
	}
	
	public function preRemoveHandler(OrganisationMember $member, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(OrganisationMember $member, LifecycleEventArgs $event) {
	}
}