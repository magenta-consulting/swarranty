<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__newsletter_subscription")
 */
class NewsletterSubscription extends Thing {
	const TITLE_PRODUCT_PROMOTIONS = 'PRODUCT_PROMOTIONS';
	
	public function __construct() {
		$this->name    = self::TITLE_PRODUCT_PROMOTIONS;
		$this->enabled = true;
	}
	
	/**
	 * @var Customer|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", cascade={"persist", "merge"}, inversedBy="newsletterSubscription")
	 * @ORM\JoinColumn(name="id_customer", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $customer;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string")
	 */
	protected $email;
	
	/**
	 * @return null|string
	 */
	public function getEmail(): ?string {
		return $this->email;
	}
	
	/**
	 * @param null|string $email
	 */
	public function setEmail(?string $email): void {
		$this->email = $email;
	}
	
	/**
	 * @return Customer|null
	 */
	public function getCustomer(): ?Customer {
		return $this->customer;
	}
	
	/**
	 * @param Customer|null $customer
	 */
	public function setCustomer(?Customer $customer): void {
		$this->customer = $customer;
	}
}