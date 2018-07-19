<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceNote;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceSheetListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfAfterOperation(ServiceSheet $sheet, LifecycleEventArgs $event) {
//		$manager->flush();
	}
	
	private function updateInfo(ServiceSheet $sheet, LifecycleEventArgs $event) {
		/** @var EntityManager $manager */
		$manager = $event->getEntityManager();
		if( ! empty($apmt = $sheet->getAppointment())) {
			$sheet->setCase($apmt->getCase());
		}
	}
	
	public function preUpdateHandler(ServiceSheet $sheet, LifecycleEventArgs $event) {
		$this->updateInfo($sheet, $event);
	}
	
	public function postUpdateHandler(ServiceSheet $sheet, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($sheet);
		$this->updateInfAfterOperation($sheet, $event);
//		$manager = $event->getEntityManager();
	}
	
	public function prePersistHandler(ServiceSheet $sheet, LifecycleEventArgs $event) {
		$this->updateInfo($sheet, $event);
	}
	
	public function postPersistHandler(ServiceSheet $sheet, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($sheet, $event);
//		$manager = $event->getEntityManager();

//		$this->handleAdminEmail($sheet);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(ServiceSheet $sheet, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(ServiceSheet $sheet, LifecycleEventArgs $event) {
		
	}
	
	public function postLoadHandler(ServiceSheet $sheet, LifecycleEventArgs $args) {
		if(empty($sheet->getNumber())) {
			$sheet->initiateNumber();
			$manager = $args->getEntityManager();
			$manager->persist($sheet);
			$manager->flush($sheet);
		}
		
	}
}