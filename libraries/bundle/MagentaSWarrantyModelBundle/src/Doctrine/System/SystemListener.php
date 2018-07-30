<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\System;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\System;
use Psr\Container\ContainerInterface;

class SystemListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfoAfterOperation(System $system, LifecycleEventArgs $event) {
		$this->updateInfo($system, $event);
		$manager  = $event->getEntityManager();
		$registry = $this->container->get('doctrine');
	}
	
	private function updateInfo(System $system, LifecycleEventArgs $event) {
	}
	
	private function updateInfoBeforeOperation(System $system, LifecycleEventArgs $event) {
		$this->updateInfo($system, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
		$systemRepo = $registry->getRepository(System::class);
		
		$uow = $manager->getUnitOfWork();
		
	}
	
	public function preFlushHandler(System $system, PreFlushEventArgs $event) {
		$manager        = $event->getEntityManager();
		$registry       = $this->container->get('doctrine');
		$orgs           = $system->getOrganisations();
		$uow            = $manager->getUnitOfWork();
		$originalED     = $uow->getOriginalEntityData($system);
		$lastNotifiedAt = $originalED['lastNotifiedAt'];
		
		if(count($system->notificationTypes) > 0) {
			/** @var Organisation $org */
			foreach($orgs as $org) {
				if(in_array(System::NOTIFICATION_WARRANTY_NEW_REGISTRATION, $system->notificationTypes)) {
					$qb = $manager->createQueryBuilder();
					$qb->select('w')->from(Warranty::class, 'w');
					$expr = $qb->expr();
					$qb->andWhere($expr->like('w.status', $expr->literal(Warranty::STATUS_NEW)));
					$qb->join('w.customer', 'customer')
					   ->join('customer.organisation', 'organisation');
					$qb->andWhere($expr->eq('organisation.id', $org->getId()));
					
					$wResult = $qb->getQuery()->getResult();
					
					if($newEntriesCount = count($wResult) > 0) {
						$orgMsg = $org->prepareNewRegistrationMessage([ 'total' => [ 'new' => $newEntriesCount ] ]);
						$emails = $orgMsg['recipients'];
						
						$message = (new \Swift_Message($orgMsg['subject']))
							->setFrom('no-reply@' . $system->getDomain())
							->setTo($emails)
							->setBody(
								$orgMsg['body'],
								'text/html'
							)/*
				 * If you also want to include a plaintext version of the message
				->addPart(
					$this->renderView(
						'emails/registration.txt.twig',
						array('name' => $name)
					),
					'text/plain'
				)
				*/
						;
						$this->container->get('mailer')->send($message);
					}
				}
				
				if(in_array(System::NOTIFICATION_TECHNICIAN_NEW_ASSIGNMENT, $system->notificationTypes)) {
					// get case where apmt.createAt >= lastNotifiedAt
					$qb = $manager->createQueryBuilder();
					$qb->select('c as warranty_case, count(distinct c) as count')->from(WarrantyCase::class, 'c');
					$expr = $qb->expr();
					$qb->join('c.appointments', 'apmt');
					$qb->join('c.assignee', 'assignee');
					$qb->andWhere($expr->gte('apmt.createdAt', ':lastNotifiedAt'))
					   ->setParameter(':lastNotifiedAt', $lastNotifiedAt);
					$qb->groupBy('assignee.id')
					   ->having('count(distinct c) > 0');
					
					$query   = $qb->getQuery();
					$sql     = $query->getSQL();
					$results = $query->getResult();
					foreach($results as $result) {
						/** @var WarrantyCase $case */
						$case            = $result['warranty_case'];
						$assignee        = $case->getAssignee();
						$newEntriesCount = $result['count'];
						if($newEntriesCount > 0) {
							$asgnMessage = $assignee->prepareNewAssignmentMessage([ 'new' => $newEntriesCount ]);
							$email  = $asgnMessage['recipient'];
							
							$swiftMessage = (new \Swift_Message($asgnMessage['subject']))
								->setFrom('no-reply@' . $system->getDomain())
								->setTo($email)
								->setBody(
									$asgnMessage['body'],
									'text/html'
								)/*
				 * If you also want to include a plaintext version of the message
				->addPart(
					$this->renderView(
						'emails/registration.txt.twig',
						array('name' => $name)
					),
					'text/plain'
				)
				*/
							;
							$this->container->get('mailer')->send($swiftMessage);
						}
					}
				}
			}
		}
	}
	
	public
	function preUpdateHandler(
		System $system, LifecycleEventArgs $event
	) {
		$this->updateInfoBeforeOperation($system, $event);
	}
	
	public
	function postUpdateHandler(
		System $system, LifecycleEventArgs $event
	) {
		$this->updateInfoAfterOperation($system, $event);
	}
	
	public
	function prePersistHandler(
		System $system, LifecycleEventArgs $event
	) {
		$this->updateInfoBeforeOperation($system, $event);
		
	}
	
	public
	function postPersistHandler(
		System $system, LifecycleEventArgs $event
	) {
		$this->updateInfoAfterOperation($system, $event);
		/** @var EntityManager $manager */
		$manager  = $event->getObjectManager();
		$registry = $this->container->get('doctrine');
		
	}
	
	public
	function preRemoveHandler(
		System $system, LifecycleEventArgs $event
	) {
	}
	
	public
	function postRemoveHandler(
		System $system, LifecycleEventArgs $event
	) {
	}
}