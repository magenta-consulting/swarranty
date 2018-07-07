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
	}
	
	private function updateInfo(OrganisationMember $member, LifecycleEventArgs $event) {
		/** @var Person $person */
		$person = $member->getPerson();
		$email  = $member->getEmail();
		$pEmail = null;
		
		if( ! empty($person)) {
			$pEmail = $person->getEmail();
		}
		
		if( ! empty($email) && ! (empty($person) || $pEmail === $email)) {
			if(empty($pEmail)) {
				$person->setEmail($email);
			}
		}
	}
	
	private
	function updateInfoBeforeOperation(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
		$this->updateInfo($member, $event);
		
	}
	
	public
	function preUpdateHandler(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
		$this->updateInfoBeforeOperation($member, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
		$personRepo = $registry->getRepository(Person::class);
		
		$uow  = $manager->getUnitOfWork();
		/** @var Person $person */
		$person = $member->getPerson();
		$email  = $member->getEmail();
		$pEmail = null;
		
		if( ! empty($person)) {
			$pEmail = $person->getEmail();
		}
		
		if( ! empty($email) && ! (empty($person) || $pEmail === $email)) {
			/** @var Person $m_person */
			if(empty($m_person = $personRepo->findOneBy([ 'email' => $email ]))) {
				$m_person = new Person();
				$m_person->copyScalarPropertiesFrom($person);
				$m_person->setEmail($email);
			}
			$personCS = $uow->getEntityChangeSet($person);
			if(array_key_exists('name', $personCS)) {
				$person->setName($personCS['name'][0]);
//				$uow->getEntityChangeSet($person)['name'][1] = $personCS['name'][0];
				$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Person::class), $person); // Cannot call recomputeSingleEntityChangeSet before computeChangeSet on an entity.
				$manager->persist($person);
			}
			$person->removeMember($member);
			$m_person->addMember($member);
			$manager->persist($m_person);
//			$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Person::class), $person); // Cannot call recomputeSingleEntityChangeSet before computeChangeSet on an entity.
//			$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Person::class), $m_person); // Cannot call recomputeSingleEntityChangeSet before computeChangeSet on an entity.
//			$manager->persist($member);
//			$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(OrganisationMember::class), $member); // Cannot call recomputeSingleEntityChangeSet before computeChangeSet on an entity.
		
		}
	}
	
	public
	function postUpdateHandler(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
		$this->updateInfoAfterOperation($member, $event);
		$manager = $event->getEntityManager();
		$uow     = $manager->getUnitOfWork();
		$manager->persist($person = $member->getPerson());
		$manager->flush($person);
	}
	
	public
	function prePersistHandler(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
		$this->updateInfoBeforeOperation($member, $event);
	}
	
	public
	function postPersistHandler(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
		$this->updateInfoAfterOperation($member, $event);
	}
	
	public
	function preRemoveHandler(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
	}
	
	public
	function postRemoveHandler(
		OrganisationMember $member, LifecycleEventArgs $event
	) {
	}
}