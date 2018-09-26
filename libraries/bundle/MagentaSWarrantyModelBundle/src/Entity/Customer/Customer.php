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
 * @ORM\Table(name="customer__customer")
 */
class Customer extends Thing {
	
	public function __construct() {
		$this->warranties    = new ArrayCollection();
		$this->registrations = new ArrayCollection();
	}
	
	public function isSubscribedToNewsletter() {
		return ! empty($this->newsletterSubscription);
	}
	
	public function generateFullText() {
		parent::generateFullText();
		
		return $this->fullText .= ' ' . sprintf('email:%s phone:%s address:%s postal:%s', $this->email, $this->telephone, $this->homeAddress, $this->homePostalCode);
	}
	
	public function initiateEmailVerificationToken() {
		if(empty($this->emailVerificationToken)) {
			$this->emailVerificationToken = User::generateCharacterCode(null, 16);
		}
		
		return $this->emailVerificationToken;
	}
	
	/**
	 * @var NewsletterSubscription|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\NewsletterSubscription", mappedBy="customer", cascade={"persist","merge"})
	 */
	protected $newsletterSubscription;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", mappedBy="customer", cascade={"persist","merge"})
	 */
	protected $warranties;
	
	public function addWarranty(Warranty $w) {
		$this->warranties->add($w);
		$w->setCustomer($this);
	}
	
	public function removeWarranty(Warranty $w) {
		$this->warranties->removeElement($w);
		$w->setCustomer(null);
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration", mappedBy="customer", cascade={"persist","merge"})
	 */
	protected $registrations;
	
	public function addRegistration(Registration $r) {
		$this->registrations->add($r);
		$r->setCustomer($this);
	}
	
	public function removeRegistration(Registration $r) {
		$this->registrations->removeElement($r);
		$r->setCustomer(null);
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="customers", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @var Person|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person", cascade={"persist", "merge"}, inversedBy="customers")
	 * @ORM\JoinColumn(name="id_person", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $person;
	
	/**
	 * @var boolean|null
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $emailVerified = false;
	
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
	protected $email;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $emailVerificationToken;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $homeAddress;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $homePostalCode;
	
	/**
	 * @var integer|null
	 * @ORM\Column(type="integer",nullable=true)
	 */
	protected $dialingCode = 65;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $telephone;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $addressUnitNumber;
	
	/**
	 * @return \DateTime|null
	 */
	public function getBirthDate(): ?\DateTime {
		return $this->birthDate;
	}
	
	/**
	 * @param \DateTime|null $birthDate
	 */
	public function setBirthDate(?\DateTime $birthDate): void {
		$this->birthDate = $birthDate;
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
	
	/**
	 * @return Person|null
	 */
	public function getPerson(): ?Person {
		return $this->person;
	}
	
	/**
	 * @param Person|null $person
	 */
	public function setPerson(?Person $person): void {
		$this->person = $person;
	}
	
	/**
	 * @return null|string
	 */
	public function getHomePostalCode(): ?string {
		return $this->homePostalCode;
	}
	
	/**
	 * @param null|string $homePostalCode
	 */
	public function setHomePostalCode(?string $homePostalCode): void {
		$this->homePostalCode = $homePostalCode;
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
	 * @return null|integer
	 */
	public function getDialingCode(): ?int {
		return $this->dialingCode;
	}
	
	/**
	 * @param null|integer $dialingCode
	 */
	public function setDialingCode(?int $dialingCode): void {
		$this->dialingCode = $dialingCode;
	}
	
	/**
	 * @return Collection
	 */
	public function getRegistrations(): Collection {
		return $this->registrations;
	}
	
	/**
	 * @param Collection $registrations
	 */
	public function setRegistrations(Collection $registrations): void {
		$this->registrations = $registrations;
	}
	
	/**
	 * @return boolean|null
	 */
	public function isEmailVerified(): ?bool {
		return $this->emailVerified;
	}
	
	/**
	 * @param boolean|null $emailVerified
	 */
	public function setEmailVerified(?bool $emailVerified): void {
		$this->emailVerified = $emailVerified;
	}
	
	/**
	 * @return null|string
	 */
	public function getEmailVerificationToken(): ?string {
		return $this->emailVerificationToken;
	}
	
	/**
	 * @param null|string $emailVerificationToken
	 */
	public function setEmailVerificationToken(?string $emailVerificationToken): void {
		$this->emailVerificationToken = $emailVerificationToken;
	}
	
	/**
	 * @return null|string
	 */
	public function getAddressUnitNumber(): ?string {
		return $this->addressUnitNumber;
	}
	
	/**
	 * @param null|string $addressUnitNumber
	 */
	public function setAddressUnitNumber(?string $addressUnitNumber): void {
		$this->addressUnitNumber = $addressUnitNumber;
	}
	
	
}
