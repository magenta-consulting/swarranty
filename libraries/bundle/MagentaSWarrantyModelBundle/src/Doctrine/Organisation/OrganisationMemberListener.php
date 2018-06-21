<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Organisation;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrganisationMemberListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	public function preUpdateHandler(Organisation $organisation, LifecycleEventArgs $event) {
	
	}
	
	public function postUpdateHandler(Organisation $organisation, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($organisation);
	}
	
	public function prePersistHandler(Organisation $organisation, LifecycleEventArgs $event) {
	
	}
	
	public function postPersistHandler(Organisation $organisation, LifecycleEventArgs $event) {
	
	}
}