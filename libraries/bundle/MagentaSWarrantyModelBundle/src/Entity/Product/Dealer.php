<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__dealer")
 */
class Dealer extends Thing {
	
	function __construct() {
		$this->categories = new ArrayCollection();
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", mappedBy="dealer", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $warranties;
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="dealers", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $contactName;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $contactNumber;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $email;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $address;
	
	/**
	 * @return string
	 */
	public function getContactName(): string {
		return $this->contactName;
	}
	
	/**
	 * @param string $contactName
	 */
	public function setContactName(string $contactName): void {
		$this->contactName = $contactName;
	}
	
	/**
	 * @return string
	 */
	public function getContactNumber(): string {
		return $this->contactNumber;
	}
	
	/**
	 * @param string $contactNumber
	 */
	public function setContactNumber(string $contactNumber): void {
		$this->contactNumber = $contactNumber;
	}
	
	/**
	 * @return string
	 */
	public function getEmail(): string {
		return $this->email;
	}
	
	/**
	 * @param string $email
	 */
	public function setEmail(string $email): void {
		$this->email = $email;
	}
	
	/**
	 * @return string
	 */
	public function getAddress(): string {
		return $this->address;
	}
	
	/**
	 * @param string $address
	 */
	public function setAddress(string $address): void {
		$this->address = $address;
	}
	
	/**
	 * @return Collection
	 */
	public function getWarranties(): Collection {
		return $this->warranties;
	}
	
	/**
	 * @param Collection $warranties
	 */
	public function setWarranties(Collection $warranties): void {
		$this->warranties = $warranties;
	}
	
	/**
	 * @return Organisation|null
	 */
	public function getOrganisation(): ?Organisation {
		return $this->organisation;
	}
	
	/**
	 * @param Organisation|null $organisation
	 */
	public function setOrganisation(?Organisation $organisation): void {
		$this->organisation = $organisation;
	}
}
