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

class ServiceNoteListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfAfterOperation(ServiceNote $note, LifecycleEventArgs $event) {
//		$manager->flush();
	}
	
	private function updateInfo(ServiceNote $note, LifecycleEventArgs $event) {
		/** @var EntityManager $manager */
		$manager = $event->getEntityManager();
		if( ! empty($apmt = $note->getAppointment())) {
			$note->setCase($apmt->getCase());
		}
	}
	
	public function preUpdateHandler(ServiceNote $note, LifecycleEventArgs $event) {
		$this->updateInfo($note, $event);
//		if( ! empty($note->getRegNo())) {
//			$note->setRegNo(strtoupper($note->getRegNo()));
//		}

//		if(empty($note->getName())) {
//			$note->setName($note->getRegNo());
//		}
//		$note->setSlug($this->container->get('bean_core.string')->slugify($note->getName()));

//		if(empty($note->getCode())) {
//			if( ! empty($note->getRegNo())) {
//				$note->setCode($note->getRegNo());
//			} else {
//				$note->setCode($note->getSlug());
//			}
//		}
//		$note->setCode(strtoupper(trim($note->getCode())));
	}
	
	public function postUpdateHandler(ServiceNote $note, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($note);
		$this->updateInfAfterOperation($note, $event);
//		$manager = $event->getEntityManager();
	}
	
	public function prePersistHandler(ServiceNote $note, LifecycleEventArgs $event) {
		$this->updateInfo($note, $event);
		$c = $note->getCase();
		if($c->getStatus() === WarrantyCase::STATUS_ASSIGNED) {
			$c->markStatusAs(WarrantyCase::STATUS_RESPONDED);
		} elseif($c->getStatus() === WarrantyCase::STATUS_NEW) {
			if( ! empty($c->getAssignee())) {
				$c->markStatusAs(WarrantyCase::STATUS_RESPONDED);
			}
		}
	}
	
	public function postPersistHandler(ServiceNote $note, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($note, $event);
//		$manager = $event->getEntityManager();

//		$this->handleAdminEmail($note);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(ServiceNote $note, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(ServiceNote $note, LifecycleEventArgs $event) {
		
	}
	
}