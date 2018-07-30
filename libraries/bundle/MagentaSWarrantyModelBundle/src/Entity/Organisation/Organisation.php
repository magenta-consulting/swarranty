<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation;

use Bean\Component\Organization\Model\Organization as OrganizationModel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\WarrantyModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\System;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="organisation__organisation")
 */
class Organisation extends OrganizationModel {
	const FIELD_REGISTRATION = [
		'form_field.label_customer_telephone'           => 'customer.telephone',
		'form_field.label_customer_email'               => 'customer.email',
		'form_field.label_warranty_productSerialNumber' => 'warranty.productSerialNumber'
	];
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	function __construct() {
		parent::__construct();
	}
	
	public function getMembersWithApprovePermission() {
		$criteria = Criteria::create();
		$expr     = Criteria::expr();
		$roles    = $this->getSystem()->getModuleByCode(WarrantyModule::MODULE_CODE)->getRolesWithPermission(ACEntry::PERMISSION_APPROVE);
		if(empty($roles)) {
			return new ArrayCollection();
		}
		
		$criteria->where(
			$expr->in('role', $roles)
		);
		
		/** @var ArrayCollection $mems */
		$mems = $this->members;
		
		return $mems->matching($criteria);
	}
	
	public function prepareNewRegistrationMessage($data = []) {
		$mt = $this->getMessageTemplateByType(MessageTemplate::TYPE_WARRANTY_NEW_REGISTRATION);
		
		$recipients = [];
		
		$members = $this->getMembersWithApprovePermission();
		
		/** @var OrganisationMember $member */
		foreach($members as $member) {
			$recipients[] = $member->getEmail();
		}
		
		if(empty($mt)) {
			return [ 'recipients' => $recipients, 'subject' => '', 'body' => '' ];
		}
		
		$bc = $mt->getContent();
		$bc = str_replace('{number_of_new_entries}', $data['total']['new'], $bc);
		
		return [ 'recipients' => $recipients, 'subject' => $mt->getSubject(), 'body' => $bc ];
	}
	
	/**
	 * @param Media $logo |null
	 */
	public function setLogo(?Media $logo): void {
		if( ! empty($logo)) {
			$logo->setLogoOrganisation($this);
		}
		if( ! empty($this->logo)) {
			$this->logo->setLogoOrganisation(null);
		}
		$this->logo = $logo;
	}
	
	/**
	 * @param User $adminUser
	 */
	public function setAdminUser(User $adminUser): void {
		$this->adminUser = $adminUser;
		$adminUser->setAdminOrganisation($this);
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", mappedBy="organization", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $members;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $roles;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $messageTemplates;
	
	public function getMessageTemplateByType($type) {
		/** @var MessageTemplate $mt */
		foreach($this->messageTemplates as $mt) {
			if($mt->isEnabled() && $mt->getType() === $type) {
				return $mt;
			}
		}
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $serviceZones;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $categories;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSubCategory", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $subCategories;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSupplier", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $suppliers;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $brands;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $dealers;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", mappedBy="organisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $customers;
	
	
	/**
	 * @var System|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\System\System", inversedBy="organisations", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_system", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $system;
	
	/**
	 * @var User|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\User\User", mappedBy="adminOrganisation", cascade={"persist","merge"})
	 */
	protected $adminUser;
	
	/**
	 * @var Media|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="logoOrganisation", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $logo;
	
	/**
	 * @var array
	 * @ORM\Column(type="magenta_json")
	 */
	protected $fieldRequirements = [];
	
	/**
	 * @var integer
	 * @ORM\Column(type="integer", options={"default":30})
	 */
	protected $nearExpiryPeriod = 30;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $enabled = true;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $tos;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $psnLocationUrl;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $productRegUrl;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $assigneeUrl;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $subDomain;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $adminDomain;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $emailVerificationUrl;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $psnLocationInstruction;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $dataPolicy;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $name;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $code;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $adminEmail;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $adminFamilyName;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $adminGivenName;
	
	
	/**
	 * @var string|null
	 */
	protected $adminPassword;
	
	/**
	 * @return Media|null
	 */
	public function getLogo(): ?Media {
		return $this->logo;
	}
	
	
	/**
	 * @return Collection
	 */
	public function getRoles(): Collection {
		return $this->roles;
	}
	
	/**
	 * @param Collection $roles
	 */
	public function setRoles(Collection $roles): void {
		$this->roles = $roles;
	}
	
	/**
	 * @return null|string
	 */
	public function getAdminEmail(): ?string {
		return $this->adminEmail;
	}
	
	/**
	 * @param null|string $adminEmail
	 */
	public function setAdminEmail(?string $adminEmail): void {
		$this->adminEmail = $adminEmail;
	}
	
	/**
	 * @return null|string
	 */
	public function getAdminPassword(): ?string {
		return $this->adminPassword;
	}
	
	/**
	 * @param null|string $adminPassword
	 */
	public function setAdminPassword(?string $adminPassword): void {
		$this->adminPassword = $adminPassword;
	}
	
	/**
	 * @return User
	 */
	public function getAdminUser(): ?User {
		return $this->adminUser;
	}
	
	/**
	 * @return null|string
	 */
	public function getAdminFamilyName(): ?string {
		return $this->adminFamilyName;
	}
	
	/**
	 * @param null|string $adminFamilyName
	 */
	public function setAdminFamilyName(?string $adminFamilyName): void {
		$this->adminFamilyName = $adminFamilyName;
	}
	
	/**
	 * @return null|string
	 */
	public function getAdminGivenName(): ?string {
		return $this->adminGivenName;
	}
	
	/**
	 * @param null|string $adminGivenName
	 */
	public function setAdminGivenName(?string $adminGivenName): void {
		$this->adminGivenName = $adminGivenName;
	}
	
	/**
	 * @return System|null
	 */
	public function getSystem(): ?System {
		return $this->system;
	}
	
	/**
	 * @param System|null $system
	 */
	public function setSystem(?System $system): void {
		$this->system = $system;
	}
	
	/**
	 * @return Collection
	 */
	public function getCategories(): Collection {
		return $this->categories;
	}
	
	/**
	 * @param Collection $categories
	 */
	public function setCategories(Collection $categories): void {
		$this->categories = $categories;
	}
	
	/**
	 * @return Collection
	 */
	public function getSubCategories(): Collection {
		return $this->subCategories;
	}
	
	/**
	 * @param Collection $subCategories
	 */
	public function setSubCategories(Collection $subCategories): void {
		$this->subCategories = $subCategories;
	}
	
	/**
	 * @return Collection
	 */
	public function getSuppliers(): Collection {
		return $this->suppliers;
	}
	
	/**
	 * @param Collection $suppliers
	 */
	public function setSuppliers(Collection $suppliers): void {
		$this->suppliers = $suppliers;
	}
	
	/**
	 * @return Collection
	 */
	public function getBrands(): Collection {
		return $this->brands;
	}
	
	/**
	 * @param Collection $brands
	 */
	public function setBrands(Collection $brands): void {
		$this->brands = $brands;
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
	 * @return Collection
	 */
	public function getDealers(): Collection {
		return $this->dealers;
	}
	
	/**
	 * @param Collection $dealers
	 */
	public function setDealers(Collection $dealers): void {
		$this->dealers = $dealers;
	}
	
	/**
	 * @return null|string
	 */
	public function getTos(): ?string {
		return $this->tos;
	}
	
	/**
	 * @param null|string $tos
	 */
	public function setTos(?string $tos): void {
		$this->tos = $tos;
	}
	
	/**
	 * @return Collection
	 */
	public function getCustomers(): Collection {
		return $this->customers;
	}
	
	/**
	 * @param Collection $customers
	 */
	public function setCustomers(Collection $customers): void {
		$this->customers = $customers;
	}
	
	/**
	 * @return int
	 */
	public function getNearExpiryPeriod(): int {
		return $this->nearExpiryPeriod;
	}
	
	/**
	 * @param int $nearExpiryPeriod
	 */
	public function setNearExpiryPeriod(int $nearExpiryPeriod): void {
		$this->nearExpiryPeriod = $nearExpiryPeriod;
	}
	
	/**
	 * @return array
	 */
	public function getFieldRequirements(): ?array {
		return $this->fieldRequirements;
	}
	
	/**
	 * @param array $fieldRequirements
	 */
	public function setFieldRequirements(array $fieldRequirements): void {
		$this->fieldRequirements = $fieldRequirements;
	}
	
	/**
	 * @return null|string
	 */
	public function getDataPolicy(): ?string {
		return $this->dataPolicy;
	}
	
	/**
	 * @param null|string $dataPolicy
	 */
	public function setDataPolicy(?string $dataPolicy): void {
		$this->dataPolicy = $dataPolicy;
	}
	
	/**
	 * @return Collection
	 */
	public function getMessageTemplates(): Collection {
		return $this->messageTemplates;
	}
	
	/**
	 * @param Collection $messageTemplates
	 */
	public function setMessageTemplates(Collection $messageTemplates): void {
		$this->messageTemplates = $messageTemplates;
	}
	
	/**
	 * @return null|string
	 */
	public function getPsnLocationInstruction(): ?string {
		return $this->psnLocationInstruction;
	}
	
	/**
	 * @param null|string $psnLocationInstruction
	 */
	public function setPsnLocationInstruction(?string $psnLocationInstruction): void {
		$this->psnLocationInstruction = $psnLocationInstruction;
	}
	
	/**
	 * @return null|string
	 */
	public function getPsnLocationUrl(): ?string {
		return $this->psnLocationUrl;
	}
	
	/**
	 * @param null|string $psnLocationUrl
	 */
	public function setPsnLocationUrl(?string $psnLocationUrl): void {
		$this->psnLocationUrl = $psnLocationUrl;
	}
	
	/**
	 * @return null|string
	 */
	public function getProductRegUrl(): ?string {
		return $this->productRegUrl;
	}
	
	/**
	 * @param null|string $productRegUrl
	 */
	public function setProductRegUrl(?string $productRegUrl): void {
		$this->productRegUrl = $productRegUrl;
	}
	
	/**
	 * @return null|string
	 */
	public function getEmailVerificationUrl(): ?string {
		return $this->emailVerificationUrl;
	}
	
	/**
	 * @param null|string $emailVerificationUrl
	 */
	public function setEmailVerificationUrl(?string $emailVerificationUrl): void {
		$this->emailVerificationUrl = $emailVerificationUrl;
	}
	
	/**
	 * @return null|string
	 */
	public function getSubDomain(): ?string {
		return $this->subDomain;
	}
	
	/**
	 * @param null|string $subDomain
	 */
	public function setSubDomain(?string $subDomain): void {
		$this->subDomain = $subDomain;
	}
	
	/**
	 * @return null|string
	 */
	public function getAdminDomain(): ?string {
		return $this->adminDomain;
	}
	
	/**
	 * @param null|string $adminDomain
	 */
	public function setAdminDomain(?string $adminDomain): void {
		$this->adminDomain = $adminDomain;
	}
	
	/**
	 * @return null|string
	 */
	public function getAssigneeUrl(): ?string {
		return $this->assigneeUrl;
	}
	
	/**
	 * @param null|string $assigneeUrl
	 */
	public function setAssigneeUrl(?string $assigneeUrl): void {
		$this->assigneeUrl = $assigneeUrl;
	}
	
}
