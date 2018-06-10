<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Product;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductListener {
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	private function updateInfo(Product $product) {
		$product->generateSearchText();
	}
	
	public function preUpdateHandler(Product $product, LifecycleEventArgs $event) {
		$this->updateInfo($product);
//		if( ! empty($product->getRegNo())) {
//			$product->setRegNo(strtoupper($product->getRegNo()));
//		}

//		if(empty($product->getName())) {
//			$product->setName($product->getRegNo());
//		}
//		$product->setSlug($this->container->get('bean_core.string')->slugify($product->getName()));

//		if(empty($product->getCode())) {
//			if( ! empty($product->getRegNo())) {
//				$product->setCode($product->getRegNo());
//			} else {
//				$product->setCode($product->getSlug());
//			}
//		}
//		$product->setCode(strtoupper(trim($product->getCode())));
	}
	
	public function postUpdateHandler(Product $product, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($product);
	}
	
	public function prePersistHandler(Product $product, LifecycleEventArgs $event) {
		$this->updateInfo($product);
	}
	
	public function postPersistHandler(Product $product, LifecycleEventArgs $event) {
//		$this->handleAdminEmail($product);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
	}
	
	public function preRemoveHandler(Product $product, LifecycleEventArgs $event) {
	}
	
	public function postRemoveHandler(Product $product, LifecycleEventArgs $event) {
	}
	
}