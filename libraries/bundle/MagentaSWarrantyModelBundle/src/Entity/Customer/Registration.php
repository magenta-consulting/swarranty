<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\ThingChildInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__registration")
 */
class Registration implements ThingChildInterface
{
    public function getThing(): ?Thing
    {
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
    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->warranties = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->code = User::generateCharacterCode(null, 6).'-'.$this->createdAt->format('dm-Y');
    }

    public function getOrganisation(): Organisation
    {
        return $this->customer->getOrganisation();
    }

    public function prepareEmailVerificationMessage()
    {
        $org = $this->getOrganisation();
        $mt = $org->getMessageTemplateByType(MessageTemplate::TYPE_REGISTRATION_VERIFICATION);
        if (empty($mt)) {
            return ['recipient' => $this->customer->getEmail(), 'subject' => '', 'body' => ''];
        }
        $bc = $mt->getContent();
        $system = $org->getSystem();
        $protocol = $system->isSslEnabled() ? 'https://' : 'http://';
        if (empty($domain = $org->getAdminDomain())) {
            $domain = $protocol.$org->getSubDomain().'.'.$system->getDomain();
        } else {
            $domain = $protocol.$domain;
        }

        $emailVerUrl = $domain.'/front/verify-email?token='.$this->customer->initiateEmailVerificationToken();
        $emailVerUrl .= '&amp;reg='.$this->id;
        $bc = str_replace('{verification_url}', sprintf('<a href="%1$s">%1$s</a>', $emailVerUrl), $bc);

        return ['recipient' => $this->customer->getEmail(), 'subject' => $mt->getSubject(), 'body' => $bc];
    }

    public function prepareRegCopyMessage()
    {
        $org = $this->getOrganisation();
        $mt = $org->getMessageTemplateByType(MessageTemplate::TYPE_REGISTRATION_COPY);
        if (empty($mt)) {
            return ['recipient' => $this->customer->getEmail(), 'subject' => '', 'body' => ''];
        }
        $bc = $mt->getContent();
        $system = $org->getSystem();
        $bc = str_replace('{name}', $this->customer->getName(), $bc);

        return ['recipient' => $this->customer->getEmail(), 'subject' => $mt->getSubject(), 'body' => $bc];
    }

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", mappedBy="registration", cascade={"persist","merge"}, orphanRemoval=true)
     */
    protected $warranties;

    public function addWarranty(Warranty $warranty)
    {
        $this->warranties->add($warranty);
        $warranty->setRegistration($this);
        $warranty->setCustomer($this->customer);
    }

    public function removeWarranty(Warranty $warranty)
    {
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
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $submitted = false;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $code;

    //	DIRTY FIELDS
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ageGroup;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $hearFromOnlineSearch;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $hearFromOnlineAd;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $hearFromFriendFamily;

    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $hearFromInteriorDesigner;

    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $hearFromShopWalkIn;

    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonInteriorDesigner;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $hearWalkShop;
    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $hearOthers;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean",nullable=true,  options={"default":false})
     */
    protected $reasonPromotions;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonTheBrand;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonTechnology;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonJapanese;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonTheDesign;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonAffordable;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonDesignerSuggested;
    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    protected $reasonFriendFamilySuggested;
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $reasonOthers;

    // END DIRTY FIELDS

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Collection
     */
    public function getWarranties(): Collection
    {
        return $this->warranties;
    }

    /**
     * @param Collection $warranties
     */
    public function setWarranties(Collection $warranties): void
    {
        $this->warranties = $warranties;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     */
    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->verified;
    }

    /**
     * @param bool $verified
     */
    public function setVerified(bool $verified): void
    {
        $this->verified = $verified;
    }

    /**
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    /**
     * @param bool $submitted
     */
    public function setSubmitted(bool $submitted): void
    {
        $this->submitted = $submitted;
    }

    /**
     * @return null|string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param null|string $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime|null $birthDate
     */
    public function setBirthDate(?\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getHomeAddress(): ?string
    {
        return $this->homeAddress;
    }

    /**
     * @param null|string $homeAddress
     */
    public function setHomeAddress(?string $homeAddress): void
    {
        $this->homeAddress = $homeAddress;
    }

    /**
     * @return null|string
     */
    public function getHomePostalCode(): ?string
    {
        return $this->homePostalCode;
    }

    /**
     * @param null|string $homePostalCode
     */
    public function setHomePostalCode(?string $homePostalCode): void
    {
        $this->homePostalCode = $homePostalCode;
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

    /**
     * @return int|null
     */
    public function getDialingCode(): ?int
    {
        return $this->dialingCode;
    }

    /**
     * @param int|null $dialingCode
     */
    public function setDialingCode(?int $dialingCode): void
    {
        $this->dialingCode = $dialingCode;
    }

    /**
     * @return null|string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param null|string $telephone
     */
    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return null|string
     */
    public function getAgeGroup(): ?string
    {
        return $this->ageGroup;
    }

    /**
     * @param null|string $ageGroup
     */
    public function setAgeGroup(?string $ageGroup): void
    {
        $this->ageGroup = $ageGroup;
    }

    /**
     * @return bool|null
     */
    public function isHearFromOnlineSearch(): ?bool
    {
        return $this->hearFromOnlineSearch;
    }

    /**
     * @param bool|null $hearFromOnlineSearch
     */
    public function setHearFromOnlineSearch(?bool $hearFromOnlineSearch): void
    {
        $this->hearFromOnlineSearch = $hearFromOnlineSearch;
    }

    /**
     * @return bool|null
     */
    public function isHearFromOnlineAd(): ?bool
    {
        return $this->hearFromOnlineAd;
    }

    /**
     * @param bool|null $hearFromOnlineAd
     */
    public function setHearFromOnlineAd(?bool $hearFromOnlineAd): void
    {
        $this->hearFromOnlineAd = $hearFromOnlineAd;
    }

    /**
     * @return bool|null
     */
    public function isHearFromFriendFamily(): ?bool
    {
        return $this->hearFromFriendFamily;
    }

    /**
     * @param bool|null $hearFromFriendFamily
     */
    public function setHearFromFriendFamily(?bool $hearFromFriendFamily): void
    {
        $this->hearFromFriendFamily = $hearFromFriendFamily;
    }

    /**
     * @return bool|null
     */
    public function isReasonInteriorDesigner(): ?bool
    {
        return $this->reasonInteriorDesigner;
    }

    /**
     * @param bool|null $reasonInteriorDesigner
     */
    public function setReasonInteriorDesigner(?bool $reasonInteriorDesigner): void
    {
        $this->reasonInteriorDesigner = $reasonInteriorDesigner;
    }

    /**
     * @return bool|null
     */
    public function getHearWalkShop(): ?bool
    {
        return $this->hearWalkShop;
    }

    /**
     * @param bool|null $hearWalkShop
     */
    public function setHearWalkShop(?bool $hearWalkShop): void
    {
        $this->hearWalkShop = $hearWalkShop;
    }

    /**
     * @return null|string
     */
    public function getHearOthers(): ?string
    {
        return $this->hearOthers;
    }

    /**
     * @param null|string $hearOthers
     */
    public function setHearOthers(?string $hearOthers): void
    {
        $this->hearOthers = $hearOthers;
    }

    /**
     * @return bool|null
     */
    public function isReasonPromotions(): ?bool
    {
        return $this->reasonPromotions;
    }

    /**
     * @param bool|null $reasonPromotions
     */
    public function setReasonPromotions(?bool $reasonPromotions): void
    {
        $this->reasonPromotions = $reasonPromotions;
    }

    /**
     * @return bool|null
     */
    public function isReasonTheBrand(): ?bool
    {
        return $this->reasonTheBrand;
    }

    /**
     * @param bool|null $reasonTheBrand
     */
    public function setReasonTheBrand(?bool $reasonTheBrand): void
    {
        $this->reasonTheBrand = $reasonTheBrand;
    }

    /**
     * @return bool|null
     */
    public function isReasonTechnology(): ?bool
    {
        return $this->reasonTechnology;
    }

    /**
     * @param bool|null $reasonTechnology
     */
    public function setReasonTechnology(?bool $reasonTechnology): void
    {
        $this->reasonTechnology = $reasonTechnology;
    }

    /**
     * @return bool|null
     */
    public function isReasonJapanese(): ?bool
    {
        return $this->reasonJapanese;
    }

    /**
     * @param bool|null $reasonJapanese
     */
    public function setReasonJapanese(?bool $reasonJapanese): void
    {
        $this->reasonJapanese = $reasonJapanese;
    }

    /**
     * @return bool|null
     */
    public function isReasonTheDesign(): ?bool
    {
        return $this->reasonTheDesign;
    }

    /**
     * @param bool|null $reasonTheDesign
     */
    public function setReasonTheDesign(?bool $reasonTheDesign): void
    {
        $this->reasonTheDesign = $reasonTheDesign;
    }

    /**
     * @return bool|null
     */
    public function isReasonAffordable(): ?bool
    {
        return $this->reasonAffordable;
    }

    /**
     * @param bool|null $reasonAffordable
     */
    public function setReasonAffordable(?bool $reasonAffordable): void
    {
        $this->reasonAffordable = $reasonAffordable;
    }

    /**
     * @return bool|null
     */
    public function isReasonDesignerSuggested(): ?bool
    {
        return $this->reasonDesignerSuggested;
    }

    /**
     * @param bool|null $reasonDesignerSuggested
     */
    public function setReasonDesignerSuggested(?bool $reasonDesignerSuggested): void
    {
        $this->reasonDesignerSuggested = $reasonDesignerSuggested;
    }

    /**
     * @return bool|null
     */
    public function isReasonFriendFamilySuggested(): ?bool
    {
        return $this->reasonFriendFamilySuggested;
    }

    /**
     * @param bool|null $reasonFriendFamilySuggested
     */
    public function setReasonFriendFamilySuggested(?bool $reasonFriendFamilySuggested): void
    {
        $this->reasonFriendFamilySuggested = $reasonFriendFamilySuggested;
    }

    /**
     * @return null|string
     */
    public function getReasonOthers(): ?string
    {
        return $this->reasonOthers;
    }

    /**
     * @param null|string $reasonOthers
     */
    public function setReasonOthers(?string $reasonOthers): void
    {
        $this->reasonOthers = $reasonOthers;
    }

    /**
     * @return bool|null
     */
    public function isHearFromInteriorDesigner(): ?bool
    {
        return $this->hearFromInteriorDesigner;
    }

    /**
     * @param bool|null $hearFromInteriorDesigner
     */
    public function setHearFromInteriorDesigner(?bool $hearFromInteriorDesigner): void
    {
        $this->hearFromInteriorDesigner = $hearFromInteriorDesigner;
    }

    /**
     * @return bool|null
     */
    public function isHearFromShopWalkIn(): ?bool
    {
        return $this->hearFromShopWalkIn;
    }

    /**
     * @param bool|null $hearFromShopWalkIn
     */
    public function setHearFromShopWalkIn(?bool $hearFromShopWalkIn): void
    {
        $this->hearFromShopWalkIn = $hearFromShopWalkIn;
    }
}
