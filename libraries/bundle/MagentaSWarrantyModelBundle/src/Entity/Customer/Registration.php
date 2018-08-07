<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\ThingChildInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__registration")
 */
class Registration implements ThingChildInterface {
	
	public function getThing(): ?Thing {
		return $this->customer;
	}
	
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
	
	public function __construct() {
		$this->warranties = new ArrayCollection();
		$this->createdAt  = new \DateTime();
		$this->code       = User::generateCharacterCode(null, 6) . '-' . $this->createdAt->format('dm-Y');
	}
	
	public function getOrganisation(): Organisation {
		return $this->customer->getOrganisation();
	}
	
	public function prepareEmailVerificationMessage() {
		$org = $this->getOrganisation();
		$mt  = $org->getMessageTemplateByType(MessageTemplate::TYPE_REGISTRATION_VERIFICATION);
		if(empty($mt)) {
			return [ 'recipient' => $this->customer->getEmail(), 'subject' => '', 'body' => '' ];
		}
		$bc       = $mt->getContent();
		$system   = $org->getSystem();
		$protocol = $system->isSslEnabled() ? 'https://' : 'http://';
		if(empty($domain = $org->getAdminDomain())) {
			$domain = $protocol . $org->getSubDomain() . '.' . $system->getDomain();
		} else {
			$domain = $protocol . $domain;
		}
		
		$emailVerUrl = $domain . '/front/verify-email?token=' . $this->customer->initiateEmailVerificationToken();
		$emailVerUrl .= '&amp;reg=' . $this->id;
		$bc          = str_replace('{verification_url}', $emailVerUrl, $bc);
		
		return [ 'recipient' => $this->customer->getEmail(), 'subject' => $mt->getSubject(), 'body' => $bc ];
	}
	
	public function prepareRegCopyMessage() {
		$org = $this->getOrganisation();
		$mt  = $org->getMessageTemplateByType(MessageTemplate::TYPE_REGISTRATION_COPY);
		if(empty($mt)) {
			return [ 'recipient' => $this->customer->getEmail(), 'subject' => '', 'body' => '' ];
		}
		$bc     = $mt->getContent();
		$system = $org->getSystem();
		$bc     = str_replace('{name}', $this->customer->getName(), $bc);
		
		return [ 'recipient' => $this->customer->getEmail(), 'subject' => $mt->getSubject(), 'body' => $bc ];
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", mappedBy="registration", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $warranties;
	
	public function addWarranty(Warranty $warranty) {
		$this->warranties->add($warranty);
		$warranty->setRegistration($this);
		$warranty->setCustomer($this->customer);
	}
	
	public function removeWarranty(Warranty $warranty) {
		$this->warranties->removeElement($warranty);
		$warranty->setRegistration(null);
	}
	
	/**
	 * @var Customer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", cascade={"persist", "merge"}, inversedBy="registrations")
	 * @ORM\JoinColumn(name="id_customer", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $customer;
	
	//	Customer Info

	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $name;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $addressUnitNumber;

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
//   End of Customer Info
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $verified = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $submitted = false;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string")
	 */
	protected $code;
	
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt(\DateTime $createdAt): void {
		$this->createdAt = $createdAt;
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
	 * @return bool
	 */
	public function isVerified(): bool {
		return $this->verified;
	}
	
	/**
	 * @param bool $verified
	 */
	public function setVerified(bool $verified): void {
		$this->verified = $verified;
	}
	
	/**
	 * @return bool
	 */
	public function isSubmitted(): bool {
		return $this->submitted;
	}
	
	/**
	 * @param bool $submitted
	 */
	public function setSubmitted(bool $submitted): void {
		$this->submitted = $submitted;
	}
	
	/**
	 * @return null|string
	 */
	public function getCode(): ?string {
		return $this->code;
	}
	
	/**
	 * @param null|string $code
	 */
	public function setCode(?string $code): void {
		$this->code = $code;
	}
	
	/**
	 * @return null|string
	 */
	public function getName(): ?string {
		return $this->name;
	}
	
	/**
	 * @param null|string $name
	 */
	public function setName(?string $name): void {
		$this->name = $name;
	}
	
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
	 * @return int|null
	 */
	public function getDialingCode(): ?int {
		return $this->dialingCode;
	}
	
	/**
	 * @param int|null $dialingCode
	 */
	public function setDialingCode(?int $dialingCode): void {
		$this->dialingCode = $dialingCode;
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
     * @return null|string
     */
    public function getAddressUnitNumber(): ?string
    {
        return $this->addressUnitNumber;
    }

    /**
     * @param null|string $addressUnitNumber
     */
    public function setAddressUnitNumber(?string $addressUnitNumber): void
    {
        $this->addressUnitNumber = $addressUnitNumber;
    }


}
