<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Person;

use \Bean\Component\Person\Model\Person as PersonModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="person__person")
 */
class Person extends PersonModel {
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	function __construct() {
		parent::__construct();
		$this->members   = new ArrayCollection();
		$this->customers = new ArrayCollection();
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", mappedBy="person", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $members;
	public function addMember(OrganisationMember $member) {
		$this->members->add($member);
		$member->setPerson($this);
	}
	
	public function removeMember(OrganisationMember $member) {
		$this->members->removeElement($member);
		$member->setPerson(null);
	}
	
	/**
	 * @var User|null
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", mappedBy="person")
	 */
	protected $customers;
	public function addCustomer(Customer $customer) {
		$this->customers->add($customer);
		$customer->setPerson($this);
	}
	
	public function removeCustomer(Customer $customer) {
		$this->customers->removeElement($customer);
		$customer->setPerson(null);
	}
	
	/**
	 * @var User|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\User\User", mappedBy="person")
	 */
	protected $user;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $name;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $birthDate;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $givenName;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $familyName;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $email;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $homeAddress;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $telephone;
	
	/**
	 * @return User|null
	 */
	public function getUser(): ?User {
		return $this->user;
	}
	
	/**
	 * @param User|null $user
	 */
	public function setUser(?User $user): void {
		$this->user = $user;
	}
	
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
	 * @return null|string
	 */
	public function getHomeAddress(): ?string {
		return $this->homeAddress;
	}
	
	/**
	 * @param null|string $homeAddress
	 */
	public function setHomeAddress(?string $homeAddress): void {
		$this->homeAddress = $homeAddress;
	}
	
	/**
	 * @return null|string
	 */
	public function getTelephone(): ?string {
		return $this->telephone;
	}
	
	/**
	 * @param null|string $telephone
	 */
	public function setTelephone(?string $telephone): void {
		$this->telephone = $telephone;
	}
	
}