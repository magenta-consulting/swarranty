<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__warranty")
 */
class Warranty {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var Customer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_customer", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $customer;
	
	/**
	 * @var Product|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_product", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $product;
	
	/**
	 * @var Dealer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_dealer", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $dealer;
	
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
	
	/**
	 * @return Dealer|null
	 */
	public function getDealer(): ?Dealer {
		return $this->dealer;
	}
	
	/**
	 * @param Dealer|null $dealer
	 */
	public function setDealer(?Dealer $dealer): void {
		$this->dealer = $dealer;
	}
	
	/**
	 * @return Product|null
	 */
	public function getProduct(): ?Product {
		return $this->product;
	}
	
	/**
	 * @param Product|null $product
	 */
	public function setProduct(?Product $product): void {
		$this->product = $product;
	}
}