<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Customer;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomerListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function updateInfo(Customer $customer)
    {
    }

    public function preUpdateHandler(Customer $customer, LifecycleEventArgs $event)
    {
        $this->updateInfo($customer);
        //		if( ! empty($customer->getRegNo())) {
//			$customer->setRegNo(strtoupper($customer->getRegNo()));
//		}

//		if(empty($customer->getName())) {
//			$customer->setName($customer->getRegNo());
//		}
//		$customer->setSlug($this->container->get('bean_core.string')->slugify($customer->getName()));

//		if(empty($customer->getCode())) {
//			if( ! empty($customer->getRegNo())) {
//				$customer->setCode($customer->getRegNo());
//			} else {
//				$customer->setCode($customer->getSlug());
//			}
//		}
//		$customer->setCode(strtoupper(trim($customer->getCode())));
    }

    public function postUpdateHandler(Customer $customer, LifecycleEventArgs $event)
    {
        //		$this->handleAdminEmail($customer);
    }

    public function prePersistHandler(Customer $customer, LifecycleEventArgs $event)
    {
        $this->updateInfo($customer);

        //		if( ! empty($customer->getRegNo())) {
//			$customer->setRegNo(strtoupper($customer->getRegNo()));
//		}
//		if(empty($customer->getName())) {
//			$customer->setName($customer->getRegNo());
//		}
//		if(empty($customer->getSlug())) {
//			$customer->setSlug($this->container->get('bean_core.string')->slugify($customer->getName()));
//		}
//		if(empty($customer->getCode())) {
//			if( ! empty($customer->getRegNo())) {
//				$customer->setCode($customer->getRegNo());
//			} else {
//				$customer->setCode($customer->getSlug());
//			}
//		}
//		$customer->setCode(strtoupper(trim($customer->getCode())));
    }

    public function postPersistHandler(Customer $customer, LifecycleEventArgs $event)
    {
        //		$this->handleAdminEmail($customer);

//        $receivers = $this->container->getParameter('mhs_mail_receivers');
//        $this->container->get('sylius.email_sender')->send('channel_partner_new_order', $receivers, array('movie' => 'NEW POSITION', 'user' => 'NEW POSITION'));
    }

    public function preRemoveHandler(Customer $customer, LifecycleEventArgs $event)
    {
    }

    public function postRemoveHandler(Customer $customer, LifecycleEventArgs $event)
    {
    }

    public function postLoadHandler(Customer $customer, LifecycleEventArgs $args)
    {
        if (empty($customer->getEmailVerificationToken()) && empty($customer->isEmailVerified())) {
            $customer->initiateEmailVerificationToken();
            $manager = $args->getEntityManager();
            $manager->persist($customer);
            $manager->flush($customer);
        }
    }
}
