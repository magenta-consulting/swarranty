<?php
namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
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
	
	private function updateInfo(WarrantyCase $case) {
		$user   = $this->container->get(UserService::class)->getUser();
		$w      = $case->getWarranty();
		$apmts  = $case->getAppointments();
		$asgnee = $case->getAssignee();
		$apmtAt = $case->getAppointmentAt();
		// completely New Case
		if($apmts->count() === 0) {
			if( ! empty($asgnee)) {
				$apmt = new CaseAppointment();
				$apmt->setAppointmentAt($apmtAt);
				$case->addAppointment($apmt);
				$asgnee->addAppointment($apmt);
				if( ! empty($person = $user->getPerson())) {
					$member = $person->getMemberOfOrganisation($case->getWarranty()->getOrganisation());
					if( ! empty($empty)) {
						$apmt->setCreator($member);
						$apmt->setCreatorName($person->getName());
					}
				}
			}
		} else {
			/** @var CaseAppointment $apmt */
			$apmt = $apmts->last();
			$case->setAssignee($asgnee = $apmt->getAssignee());
			$case->setAppointmentAt($apmt->getAppointmentAt());
		}
		
		/** @var AssigneeHistory $lastHistory */
		$lastHistory = $case->getAssigneeHistory()->last();
		if($lastHistory->getAssignee() !== $asgnee) {
			$ah = new AssigneeHistory();
			$ah->setAssignee($asgnee);
			$ah->setCase($case);
			$ah->setAssigneeName($asgnee->getPerson()->getName());
			$case->addAssigneeHistory($ah);
		}
	}
	
	public function preUpdateHandler(WarrantyCase $case, LifecycleEventArgs $event) {
		$this->updateInfo($case);
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
	}
	
	public function prePersistHandler(WarrantyCase $case, LifecycleEventArgs $event) {
		$this->updateInfo($case);
		if(empty($case->getExpiryDate())) {
			$expiryAt = $case->getPurchaseDate();
			$expiryAt->modify(sprintf("+%d months", $case->getProduct()->getWarrantyPeriod()));
			$case->setExpiryDate($expiryAt);
		}
		if( ! empty($reg = $case->getRegistration())) {
			$case->setCustomer($reg->getCustomer());
		}
	}
	
	public function postPersistHandler(WarrantyCase $case, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($case);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(WarrantyCase $case, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(WarrantyCase $case, LifecycleEventArgs $event) {
	}
	
}