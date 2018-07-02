<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Person;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PersonListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfoAfterOperation(Person $person, LifecycleEventArgs $event) {
		$this->updateInfo($person, $event);
		$manager  = $event->getEntityManager();
		$registry = $this->container->get('doctrine');
		
		$email = $person->getEmail();
		
		if( ! empty($pu = $person->getUser()) && ! empty($pu->getId()) && $pu->getEmail() !== $person->getEmail()) {
			$pu->setEmail($email);
			$manager->persist($pu);
		}
		
		if(empty($user = $pu = $person->getUser()) || empty($pu->getId())) {
			$userRepo = $registry->getRepository(User::class);
			/** @var User $user */
			if(empty($user = $userRepo->findOneBy([ 'email' => $email ]))) {
				$user = new User();
				$user->setEnabled(true);
				$user->addRole(User::ROLE_POWER_USER);
				$user->setUsername($email);
				$user->setEmail($email);
				if(empty($pu)) {
					$up = 'new-user';
				} else {
					$up = $pu->getPlainPassword();
				}
				$person->setUser($user);
				$user->setPerson($person);
				$user->setPlainPassword($up);
				$manager->persist($user);
				$manager->persist($person);
			} else {
				$person->setUser($user);
				$user->setPerson($person);
				$manager->persist($user);
				$manager->persist($person);
			}
			if( ! empty($pu)) {
				$pu->setPerson(null);
				$manager->persist($pu);
			}
		}
		if(empty($user->getUsername())) {
			$user->setUsername($email);
		}
		
		$manager->flush();
	}
	
	private function updateInfo(Person $person, LifecycleEventArgs $event) {
	}
	
	private function updateInfoBeforeOperation(Person $person, LifecycleEventArgs $event) {
		$this->updateInfo($person, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
		$personRepo = $registry->getRepository(Person::class);
		
		$uow   = $manager->getUnitOfWork();
		$email = $person->getEmail();
		
		
	}
	
	public function preUpdateHandler(Person $person, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($person, $event);
	}
	
	public function postUpdateHandler(Person $person, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($person, $event);
	}
	
	public function prePersistHandler(Person $person, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($person, $event);
	}
	
	public function postPersistHandler(Person $person, LifecycleEventArgs $event) {
		$this->updateInfoAfterOperation($person, $event);
	}
	
	public function preRemoveHandler(Person $person, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Person $person, LifecycleEventArgs $event) {
	}
}