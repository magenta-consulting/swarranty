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
		$user    = $this->container->get(UserService::class)->getUser(false);
		
	}
	
	public function preUpdateHandler(Registration $reg, LifecycleEventArgs $event) {
		$this->updateInfBeforeOperation($case, $event);
//		if( ! empty($case->getRegNo())) {
//			$case->setRegNo(strtoupper($case->getRegNo()));
//		}

//		if(empty($case->getName())) {
//			$case->setName($case->getRegNo());
//		}
//		$case->setSlug($this->container->get('bean_core.string')->slugify($case->getName()));

//		if(empty($case->getCode())) {
//			if( ! empty($case->getRegNo())) {
//				$case->setCode($case->getRegNo());
//			} else {
//				$case->setCode($case->getSlug());
//			}
//		}
//		$case->setCode(strtoupper(trim($case->getCode())));
	}
	
	public function postUpdateHandler(Registration $reg, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($case);
		$this->updateInfAfterOperation($case, $event);
//		$manager = $event->getEntityManager();
	}
	
	public function prePersistHandler(Registration $reg, LifecycleEventArgs $event) {
		$this->updateInfBeforeOperation($case, $event);
	}
	
	public function postPersistHandler(Registration $reg, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($case, $event);
//		$manager = $event->getEntityManager();

//		$this->handleAdminEmail($case);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(Registration $reg, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Registration $reg, LifecycleEventArgs $event) {
	
	}
	
	public function postLoadHandler(Registration $reg, LifecycleEventArgs $args) {
		$c = $reg->getCustomer();
		if($c->isEmailVerified()) {
			$reg->setVerified(true);
			$manager = $args->getEntityManager();
			$manager->persist($reg);
			$manager->flush($reg);
		}
	}
	
}