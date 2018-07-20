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

class WarrantyCaseListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfAfterOperation(WarrantyCase $case, LifecycleEventArgs $event) {
		$this->updateInfo($case, $event);
		$manager = $event->getEntityManager();
		$manager->flush();
	}
	
	private function updateInfo(WarrantyCase $case, LifecycleEventArgs $event) {
		/** @var EntityManager $manager */
		$manager = $event->getObjectManager();
		$uow     = $manager->getUnitOfWork();
		$w       = $case->getWarranty();
		$user    = $this->container->get(UserService::class)->getUser(false);
		
		$apmts         = $case->getAppointments();
		$asgnee        = $case->getAssignee();
		$apmtAt        = $case->getAppointmentAt();
		$apmtTo        = $case->getAppointmentTo();
		$apmt          = null;
		$serviceSheets = $case->getServiceSheets();
		
		////////////// update ParentCase - code /////////////////////
		if(empty($pc = $case->getParent())) {
			$case->initiateNumber();
		} else {
			$pc->initiateNumber();
			$pc->addChild($case);
			$case = $pc->getNumber() . '-' . $pc->getChildren()->count();
		}
		////////////// update Appointment /////////////////////
		
		// completely New Case //
		if($apmts->count() === 0) {
			if( ! empty($asgnee) || ! empty($apmtAt)) {
				if(empty($case->isAssigned())) {
					$case->markStatusAs(WarrantyCase::STATUS_ASSIGNED);
				}
				$apmt = new CaseAppointment();
				$apmt->setAppointmentAt($apmtAt);
				$apmt->setAppointmentTo($apmtTo);
				$case->addAppointment($apmt);
				
				if( ! empty($asgnee)) {
					$asgnee->addAppointment($apmt);
				}
				
				if( ! empty($user) && ! empty($person = $user->getPerson())) {
					$member = $person->getMemberOfOrganisation($case->getWarranty()->getOrganisation());
					if( ! empty($empty)) {
						$apmt->setCreator($member);
						$apmt->setCreatorName($person->getName());
					} else {
						$apmt->setCreatorName($user->getEmail());
					}
				}
				
				$manager->persist($apmt);
//				$uow->recomputeSingleEntityChangeSet($case);
			}
		} else {
			if(empty($case->isAssigned())) {
				$case->markStatusAs(WarrantyCase::STATUS_ASSIGNED);
			}
			/** @var CaseAppointment $apmt */
			$apmt = $apmts->last();
			$case->setAssignee($asgnee = $apmt->getAssignee());
			$case->setAppointmentAt($apmt->getAppointmentAt());
			$case->setAppointmentTo($apmt->getAppointmentTo());
//			if( ! empty($asgnee)) {
			$manager->persist($asgnee);
//			}
		}
		
		if( ! empty($asgnee)) {
			if(empty($case->isAssigned())) {
				$case->markStatusAs(WarrantyCase::STATUS_ASSIGNED);
			}
			
			/** @var AssigneeHistory $lastHistory */
			$lastHistory = $case->getAssigneeHistory()->last();
			if(empty($lastHistory) || $lastHistory->getAssignee() !== $asgnee) {
				$ah = new AssigneeHistory();
				$ah->setAssignee($asgnee);
				$ah->setCase($case);
				$ah->setAssigneeName($asgnee->getPerson()->getName());
				$case->addAssigneeHistory($ah);
				$manager->persist($ah);
			}
		}
		
		if($serviceSheets->count() > 0 && ! empty($apmt)) {
			/** @var ServiceSheet $ss */
			foreach($serviceSheets as $ss) {
				if( empty($ss->getAppointment())) {
					$ss->setAppointment($apmt);
					$apmt->setServiceSheet($ss);
					$manager->persist($ss);
					break;
				}
			}
		}
		
	}
	
	public function updateInfBeforeOperation(WarrantyCase $case, LifecycleEventArgs $event) {
	
	}
	
	public function preUpdateHandler(WarrantyCase $case, LifecycleEventArgs $event) {
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
	
	public function postUpdateHandler(WarrantyCase $case, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($case);
		$this->updateInfAfterOperation($case, $event);
//		$manager = $event->getEntityManager();
	}
	
	public function prePersistHandler(WarrantyCase $case, LifecycleEventArgs $event) {
		$this->updateInfBeforeOperation($case, $event);
	}
	
	public function postPersistHandler(WarrantyCase $case, LifecycleEventArgs $event) {
		$this->updateInfAfterOperation($case, $event);
//		$manager = $event->getEntityManager();

//		$this->handleAdminEmail($case);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(WarrantyCase $case, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(WarrantyCase $case, LifecycleEventArgs $event) {
	
	}
	
}