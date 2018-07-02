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
	
	private function updateInfoAfterOperation(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfo($member, $event);
		$manager = $event->getEntityManager();
		$manager->flush();
	}
	
	private function updateInfo(OrganisationMember $member, LifecycleEventArgs $event) {
	}
	
	private function updateInfoBeforeOperation(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfo($member, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
		$personRepo = $registry->getRepository(Person::class);
		
		$uow  = $manager->getUnitOfWork();
		$user = $this->container->get(UserService::class)->getUser();
		/** @var Person $person */
		$person = $member->getPerson();
		$email  = $person->getEmail();
		if( ! empty($email)) {
			if(empty($person->getId())) {
				/** @var Person $person */
				if( ! empty($m_person = $personRepo->findOneBy([ 'email' => $email ]))) {
					$person->removeMember($member);
					$member->setPerson($m_person);
					$m_person->addMember($member);
					$manager->persist($m_person);
					$manager->persist($member);
				} else {
					$m_person = $person;
				}
			} else {
				$m_person = $person;
			}
		}
	}
	
	public function preUpdateHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($member, $event);
	}
	
	public function postUpdateHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($member, $event);
	}
	
	public function prePersistHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($member, $event);
	}
	
	public function postPersistHandler(OrganisationMember $member, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($member, $event);
	}
	
	public function preRemoveHandler(OrganisationMember $member, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(OrganisationMember $member, LifecycleEventArgs $event) {
	}
}