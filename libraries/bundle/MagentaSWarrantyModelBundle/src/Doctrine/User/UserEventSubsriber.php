<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\User;

use Bean\Component\Organization\Model\OrganizationMember;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManager;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\UserInterface;
use Magenta\Bundle\SWarrantyModelBundle\Util\User\CanonicalFieldsUpdater;
use Magenta\Bundle\SWarrantyModelBundle\Util\User\PasswordUpdaterInterface;

/**
 * Doctrine listener updating the canonical username and password fields.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author David Buchmann <mail@davidbu.ch>
 */
class UserEventSubsriber implements EventSubscriber {
	private $passwordUpdater;
	private $canonicalFieldsUpdater;
	
	public function __construct(PasswordUpdaterInterface $passwordUpdater, CanonicalFieldsUpdater $canonicalFieldsUpdater) {
		$this->passwordUpdater        = $passwordUpdater;
		$this->canonicalFieldsUpdater = $canonicalFieldsUpdater;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSubscribedEvents() {
		return array(
			'prePersist',
			'preUpdate',
		);
	}
	
	/**
	 * Pre persist listener based on doctrine common.
	 *
	 * @param LifecycleEventArgs $args
	 */
	public function prePersist(LifecycleEventArgs $args) {
		$object = $args->getObject();
		if($object instanceof UserInterface) {
			$this->updateUserFields($object);
		}
	}
	
	/**
	 * Pre update listener based on doctrine common.
	 *
	 * @param LifecycleEventArgs $args
	 */
	public function preUpdate(LifecycleEventArgs $args) {
		$object = $args->getObject();
		if($object instanceof UserInterface) {
			$this->updateUserFields($object);
			$this->recomputeChangeSet($args->getObjectManager(), $object);
		}
		
		//////// MODIF 002 ///////
		if($object instanceof OrganizationMember) { // this should be placed in Org...Member class
			/** @var Person $person */
			if( ! empty($person = $object->getPerson())) {
				if( ! empty($user = $person->getUser()) && ! empty($user->getPlainPassword())) {
					$this->updateUserFields($user);
					$this->recomputeChangeSet($args->getObjectManager(), $user);
					$args->getObjectManager()->persist($user);
				}
			}
		}
		//////// END MODIF 002 ///////
	}
	
	/**
	 * Updates the user properties.
	 *
	 * @param UserInterface $user
	 */
	private function updateUserFields(UserInterface $user) {
		//////// MODIF 001 ///////
		if($user instanceof User) {
			if( ! empty($person = $user->getPerson())) {
				$user->setEmail($person->getEmail());
				$user->setUsername($person->getEmail());
			}
		}
		//////// END MODIF 001 ///////
		$this->canonicalFieldsUpdater->updateCanonicalFields($user);
		$this->passwordUpdater->hashPassword($user);
	}
	
	/**
	 * Recomputes change set for Doctrine implementations not doing it automatically after the event.
	 *
	 * @param ObjectManager $om
	 * @param UserInterface $user
	 */
	private function recomputeChangeSet(ObjectManager $om, UserInterface $user) {
		$meta = $om->getClassMetadata(get_class($user));
		
		if($om instanceof EntityManager) {
			$om->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $user);
			
			return;
		}
		
		if($om instanceof DocumentManager) {
			$om->getUnitOfWork()->recomputeSingleDocumentChangeSet($meta, $user);
		}
	}
}
