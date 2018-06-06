<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Organisation;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrganisationListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	public function preUpdateHandler(Organisation $organisation, LifecycleEventArgs $event) {
//		if( ! empty($organisation->getRegNo())) {
//			$organisation->setRegNo(strtoupper($organisation->getRegNo()));
//		}

//		if(empty($organisation->getName())) {
//			$organisation->setName($organisation->getRegNo());
//		}
//		$organisation->setSlug($this->container->get('bean_core.string')->slugify($organisation->getName()));

//		if(empty($organisation->getCode())) {
//			if( ! empty($organisation->getRegNo())) {
//				$organisation->setCode($organisation->getRegNo());
//			} else {
//				$organisation->setCode($organisation->getSlug());
//			}
//		}
//		$organisation->setCode(strtoupper(trim($organisation->getCode())));
	}
	
	public function postUpdateHandler(Organisation $organisation, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($organisation);
	}
	
	public function prePersistHandler(Organisation $organisation, LifecycleEventArgs $event) {
//		if( ! empty($organisation->getRegNo())) {
//			$organisation->setRegNo(strtoupper($organisation->getRegNo()));
//		}
//		if(empty($organisation->getName())) {
//			$organisation->setName($organisation->getRegNo());
//		}
//		if(empty($organisation->getSlug())) {
//			$organisation->setSlug($this->container->get('bean_core.string')->slugify($organisation->getName()));
//		}
//		if(empty($organisation->getCode())) {
//			if( ! empty($organisation->getRegNo())) {
//				$organisation->setCode($organisation->getRegNo());
//			} else {
//				$organisation->setCode($organisation->getSlug());
//			}
//		}
//		$organisation->setCode(strtoupper(trim($organisation->getCode())));
	}
	
	public function postPersistHandler(Organisation $organisation, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($organisation);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
//	private function handleAdminEmail(Organisation $organisation) {
//		$adminEmail = $organisation->getAdminEmail();
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
//			$person->setFamilyName($organisation->getAdminFamilyName());
//			$person->setGivenName($organisation->getAdminGivenName());
////			$adminUser->setPhone($organisation->getAdminPhone());
//
//			$adminUser->setEmail($adminEmail);
//			$adminUser->setUsername($adminEmail);
//			$adminUser->setPlainPassword($organisation->getAdminPassword());
//			$adminUser->setEnabled(true);
//			$adminUser->addRole('ROLE_USER');
////            $userManager->save($adminUser);
////            }
//
//			$position = new OrganisationMember();
////			$position->setEmail($adminEmail);
//			$position->setPerson($person);
//
//			$position->setOrganization($organisation);
//			$position->addRole(Position::ROLE_ADMIN);
//			if($organisation->isPositionExistent($position)) {
//				$employee = $this->container->get('sonata.user.manager.user')->findOneBy([ 'email' => $adminUser->getEmail() ]);
//				$managedPosition = $this->container->get('doctrine')->getRepository(Position::class)->findOneBy([
//					'employee' => $employee->getId(),
//					'employer' => $organisation->getId()
//				]);
//				$managedPosition->addRole(Position::ROLE_ADMIN);
//				$organisation->addPosition($managedPosition);
//				if(empty($managedPosition->impersistable)) {
//					$managedPosition->impersistable = true;
//					$entityManager->persist($organisation);
//					$entityManager->flush();
//				}
//			} else {
//				if(empty($position->impersistable)) {
//					$organisation->addPosition($position);
//					$position->impersistable = true;
//					$entityManager->persist($organisation);
//					$entityManager->flush();
//				}
//			}
//			$removedPositions = $organisation->purgeOldAdminPositions();
//			foreach($removedPositions as $removedPosition) {
//				$entityManager->persist($removedPosition);
//				$entityManager->flush($removedPosition);
//			}
//		}
//	}
}