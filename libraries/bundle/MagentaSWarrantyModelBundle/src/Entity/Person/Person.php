<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Person;

use \Bean\Component\Person\Model\Person as PersonModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
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
	
	public function copyScalarPropertiesFrom(Person $person) {
		$vars = get_object_vars($this);
		foreach($vars as $prop => $value) {
			$setter = 'set' . ucfirst($prop);
			$getter = 'get' . ucfirst($prop);
			if(empty($value) && method_exists($person, $setter)) {
				if( ! method_exists($person, $getter)) {
					$getter = 'is' . ucfirst($prop);
				}
				if(method_exists($person, $setter)) {
					$getterValue = $person->$getter();
					if(is_scalar($getterValue)) {
						$this->$setter($getterValue);
					}
				}
			}
		}
//		$m_person->setEmail($email);
//		$m_person->setFamilyName($person->getFamilyName());
//		$m_person->setGivenName($person->getGivenName());
//		$m_person->setName($person->getName());
//		$m_person->setEnabled(true);
//		$m_person->setHomeAddress($person->getHomeAddress());
//		$m_person->setTelephone($person->getTelephone());
//		$m_person->setBirthDate($person->getBirthDate());
//		$m_person->setDescription($person->getDescription());
	}
	
	public function initiateUser() {
		if(empty($this->user)) {
			$this->user = new User();
		}
		$this->user->setEnabled(true);
		
		$this->user->addRole(User::ROLE_POWER_USER);
		$this->user->setUsername($this->email);
		$this->user->setEmail($this->email);
		if(empty($this->user->getPlainPassword()) && empty($this->user->getPassword())) {
			$this->user->setPlainPassword($this->email);
		}
		$this->user->setPerson($this);
		
		return $this->user;
	}
	
	public function isSystemUser() {
		return ! ($this->user === null || empty($this->user->getId()));
	}
	
	/**
	 * @param null|string $email
	 */
	public function setEmail(?string $email): void {
		$this->email = $email;
	}
	
	/**
	 * @param User|null $user
	 */
	public function setUser(?User $user): void {
		if( ! empty($user)) {
			$user->setPerson($this);
			if( ! empty($this->user) && $this->user->getId() !== $user->getId()) {
				$this->user->setPerson(null);
			}
		}
		$this->user = $user;
	}
	
	public function getMemberOfOrganisation(Organisation $org) {
		/** @var OrganisationMember $m */
		foreach($this->members as $m) {
			if($m->getOrganization() === $org) {
				return $m;
			}
		}
		
		return null;
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", mappedBy="person", cascade={"persist","merge"})
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
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\User\User", cascade={"merge", "persist"}, mappedBy="person")
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
	 * @return null|string
	 */
	public function getEmail(): ?string {
		return $this->email;
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