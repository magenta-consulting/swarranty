<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegistrationListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfAfterOperation(Registration $reg, LifecycleEventArgs $event) {
		$manager = $event->getEntityManager();
	}
	
	private function updateInfBeforeOperation(Registration $reg, LifecycleEventArgs $event) {
		/** @var EntityManager $manager */
		$manager = $event->getObjectManager();
		$uow     = $manager->getUnitOfWork();
		$c       = $reg->getCustomer();
		if( ! empty($c) && $c->isEmailVerified()) {
			$reg->setVerified(true);
		}
	}
	
	public function preUpdateHandler(Registration $reg, LifecycleEventArgs $event) {
		$this->updateInfBeforeOperation($reg, $event);
	}
	
	public function postUpdateHandler(Registration $reg, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($reg);
		$this->updateInfAfterOperation($reg, $event);
//		$manager = $event->getEntityManager();
	}
	
	public function prePersistHandler(Registration $reg, LifecycleEventArgs $event) {
		$this->updateInfBeforeOperation($reg, $event);
	}
	
	public function postPersistHandler(Registration $reg, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($reg, $event);
//		$manager = $event->getEntityManager();

//		$this->handleAdminEmail($reg);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(Registration $reg, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Registration $reg, LifecycleEventArgs $event) {
		
	}
	
	public function postLoadHandler(Registration $reg, LifecycleEventArgs $args) {
		$c = $reg->getCustomer();
		if( ! empty($c) && $c->isEmailVerified()) {
			$reg->setVerified(true);
			$manager = $args->getEntityManager();
			$manager->persist($reg);
			$manager->flush($reg);
		}
	}
	
}