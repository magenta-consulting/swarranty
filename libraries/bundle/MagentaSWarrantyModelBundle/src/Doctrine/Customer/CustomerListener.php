<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomerListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfo(Customer $customer) {
	
	}
	
	public function preUpdateHandler(Customer $customer, LifecycleEventArgs $event) {
		$this->updateInfo($customer);
//		if( ! empty($customer->getRegNo())) {
//			$customer->setRegNo(strtoupper($customer->getRegNo()));
//		}

//		if(empty($customer->getName())) {
//			$customer->setName($customer->getRegNo());
//		}
//		$customer->setSlug($this->container->get('bean_core.string')->slugify($customer->getName()));

//		if(empty($customer->getCode())) {
//			if( ! empty($customer->getRegNo())) {
//				$customer->setCode($customer->getRegNo());
//			} else {
//				$customer->setCode($customer->getSlug());
//			}
//		}
//		$customer->setCode(strtoupper(trim($customer->getCode())));
	}
	
	public function postUpdateHandler(Customer $customer, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($customer);
	}
	
	public function prePersistHandler(Customer $customer, LifecycleEventArgs $event) {
		$this->updateInfo($customer);

//		if( ! empty($customer->getRegNo())) {
//			$customer->setRegNo(strtoupper($customer->getRegNo()));
//		}
//		if(empty($customer->getName())) {
//			$customer->setName($customer->getRegNo());
//		}
//		if(empty($customer->getSlug())) {
//			$customer->setSlug($this->container->get('bean_core.string')->slugify($customer->getName()));
//		}
//		if(empty($customer->getCode())) {
//			if( ! empty($customer->getRegNo())) {
//				$customer->setCode($customer->getRegNo());
//			} else {
//				$customer->setCode($customer->getSlug());
//			}
//		}
//		$customer->setCode(strtoupper(trim($customer->getCode())));
	}
	
	public function postPersistHandler(Customer $customer, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($customer);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(Customer $customer, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Customer $customer, LifecycleEventArgs $event) {
	}

//	private function handleAdminEmail(Customer $customer) {
//		$adminEmail = $customer->getAdminEmail();
//		if( ! empty($adminEmail)) {
//			$entityManager = $this->container->get('doctrine.orm.entity_manager');
////            $userManager = $this->container->get('sonata.user.manager.user');
////            $adminUser = $userManager->findOneBy(['email' => $adminEmail]);
////            if (empty($adminUser)) {
//			$adminUser = new User();
//			$person = new Person();
//			$person->setUser($adminUser);
//			$adminUser->setPerson($person);
//
//			$person->setEnabled(true);
//
//			$person->setFamilyName($customer->getAdminFamilyName());
//			$person->setGivenName($customer->getAdminGivenName());
////			$adminUser->setPhone($customer->getAdminPhone());
//
//			$adminUser->setEmail($adminEmail);
//			$adminUser->setUsername($adminEmail);
//			$adminUser->setPlainPassword($customer->getAdminPassword());
//			$adminUser->setEnabled(true);
//			$adminUser->addRole('ROLE_USER');
////            $userManager->save($adminUser);
////            }
//
//			$position = new CustomerMember();
////			$position->setEmail($adminEmail);
//			$position->setPerson($person);
//
//			$position->setOrganization($customer);
//			$position->addRole(Position::ROLE_ADMIN);
//			if($customer->isPositionExistent($position)) {
//				$employee = $this->container->get('sonata.user.manager.user')->findOneBy([ 'email' => $adminUser->getEmail() ]);
//				$managedPosition = $this->container->get('doctrine')->getRepository(Position::class)->findOneBy([
//					'employee' => $employee->getId(),
//					'employer' => $customer->getId()
//				]);
//				$managedPosition->addRole(Position::ROLE_ADMIN);
//				$customer->addPosition($managedPosition);
//				if(empty($managedPosition->impersistable)) {
//					$managedPosition->impersistable = true;
//					$entityManager->persist($customer);
//					$entityManager->flush();
//				}
//			} else {
//				if(empty($position->impersistable)) {
//					$customer->addPosition($position);
//					$position->impersistable = true;
//					$entityManager->persist($customer);
//					$entityManager->flush();
//				}
//			}
//			$removedPositions = $customer->purgeOldAdminPositions();
//			foreach($removedPositions as $removedPosition) {
//				$entityManager->persist($removedPosition);
//				$entityManager->flush($removedPosition);
//			}
//		}
//	}
}