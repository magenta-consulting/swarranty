<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\System;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FullTextSearchListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfo(FullTextSearchInterface $obj) {
		$obj->generateFullText();
		$obj->generateSearchText();
	}
	
	public function preUpdateHandler(FullTextSearchInterface $fullText, LifecycleEventArgs $event) {
		$this->updateInfo($fullText);
//		if( ! empty($fullText->getRegNo())) {
//			$fullText->setRegNo(strtoupper($fullText->getRegNo()));
//		}

//		if(empty($fullText->getName())) {
//			$fullText->setName($fullText->getRegNo());
//		}
//		$fullText->setSlug($this->container->get('bean_core.string')->slugify($fullText->getName()));

//		if(empty($fullText->getCode())) {
//			if( ! empty($fullText->getRegNo())) {
//				$fullText->setCode($fullText->getRegNo());
//			} else {
//				$fullText->setCode($fullText->getSlug());
//			}
//		}
//		$fullText->setCode(strtoupper(trim($fullText->getCode())));
	}
	
	public function postUpdateHandler(FullTextSearchInterface $fullText, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($fullText);
	}
	
	public function prePersistHandler(FullTextSearchInterface $fullText, LifecycleEventArgs $event) {
		$this->updateInfo($fullText);
	}
	
	public function postPersistHandler(FullTextSearchInterface $fullText, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($fullText);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(FullTextSearchInterface $fullText, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(FullTextSearchInterface $fullText, LifecycleEventArgs $event) {
	}
	
}