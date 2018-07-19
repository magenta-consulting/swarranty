<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CaseAppointmentListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfAfterOperation(CaseAppointment $apmt, LifecycleEventArgs $event) {
	
	}
	
	private function updateInfoBeforeOperation(CaseAppointment $apmt, LifecycleEventArgs $event) {
		/** @var EntityManager $manager */
		$manager = $event->getObjectManager();
		$uow     = $manager->getUnitOfWork();
		$case    = $apmt->getCase();
		$w       = $case->getWarranty();
		$ss      = $apmt->getServiceSheet();
		$case->addServiceSheet($ss);
		
		$org  = $w->getOrganisation();
		$user = $this->container->get(UserService::class)->getUser(false);
		if(empty($user)) {
			return;
		}
		if(empty($p = $user->getPerson())) {
			return;
		}
		if(empty($m = $p->getMemberOfOrganisation($org))) {
			return;
		};
		$apmt->setCreator($m);
	}
	
	public function preUpdateHandler(CaseAppointment $apmt, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($apmt, $event);
	}
	
	public function postUpdateHandler(CaseAppointment $apmt, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($apmt, $event);
	}
	
	public function prePersistHandler(CaseAppointment $apmt, LifecycleEventArgs $event) {
		$this->updateInfoBeforeOperation($apmt, $event);
	}
	
	public function postPersistHandler(CaseAppointment $apmt, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($apmt, $event);
	}
	
	public function preRemoveHandler(CaseAppointment $apmt, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(CaseAppointment $apmt, LifecycleEventArgs $event) {
	
	}
	
}