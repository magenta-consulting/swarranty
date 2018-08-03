<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Bean\Component\Thing\Model\ThingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearch;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearchInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\ThingChildInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__warranty")
 */
class Warranty extends FullTextSearch implements ThingChildInterface, DecisionMakingInterface, FullTextSearchInterface {
	
	public function getThing(): ?Thing {
		return $this->customer;
	}
	
	public function generateSearchText() {
		$customerInfo = '';
		$productInfo  = '';
		$customer     = $this->customer;
		$product      = $this->product;
		if( ! empty($product)) {
			// last but not least
		}
		if( ! empty($this->customer) && ! empty($this->product)) {
			$customerInfo     = $this->customer->getName() . sprintf(' (%s)', $this->customer->getTelephone());
			$productInfo      = $this->product->getName() . sprintf(' (%s)', $this->product->getModelNumber());
			$this->searchText = $productInfo . ' < ' . $customerInfo;
		}
		
	}
	
	public function generateFullText() {
		$org      = $this->getOrganisation();
		$orgName  = $org === null ? 'none' : $org->getName();
		$customer = $this->customer;
		$product  = $this->product;
		$mName    = $mNumber = $pCat = $pSubCat = $pBrand = '';
		$cName    = $cEmail = $cHAddress = $cPhone = $cHPostal = '';
		
		if( ! empty($product)) {
			$mName   = $product->getName();
			$mNumber = $product->getModelNumber();
		}
		
		if(empty($this->customer)) {
			$cft = '';
		} else {
			$cft = $this->customer->generateFullText();
		}
		if(empty($this->product)) {
			$pft = '';
		} else {
			$pft = $this->product->generateFullText();
		}
		
		return $this->fullText = 'number: ' . $this->number . ' ' . $cft . ' ' . $pft;
	}
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected
		$id;
	
	public
	function __construct() {
		$this->cases         = new ArrayCollection();
		$this->receiptImages = new ArrayCollection();
		$this->createdAt     = new \DateTime();
		$this->code          = User::generateCharacterCode(null, 6) . '-' . $this->createdAt->format('dm-Y');
		$this->initiateNumber();
	}
	
	public function prepareWarrantyApprovedNotifMessage() {
		$org = $this->getOrganisation();
		$mt  = $org->getMessageTemplateByType(MessageTemplate::TYPE_WARRANTY_APPROVED);
		if(empty($mt)) {
			return [ 'recipient' => $this->customer->getEmail(), 'subject' => '', 'body' => '' ];
		}
		$bc     = $mt->getContent();
		$system = $org->getSystem();
		$bc     = str_replace('{name}', $this->customer->getName(), $bc);
		
		$dor  = 'N.A';
		$pCat = 'N.A';
		if( ! empty($reg = $this->registration)) {
			$dor = $reg->getCreatedAt()->format('d-m-Y');
		}
		$product = $this->product;
		if( ! empty($cat = $product->getCategory())) {
			$pCat = $cat->getName();
		}
		
		$productDetailsHtml = sprintf('<div _ngcontent-c1="" class="success-item"><p _ngcontent-c1="">Warranty Registration ID: %1$s</p><p _ngcontent-c1="">Date of Registration: %2$s</p><p _ngcontent-c1="">Warranty Expiry: %3$s</p><p _ngcontent-c1="">Product Category: %4$s</p><p _ngcontent-c1="">Model Name: %5$s</p><p _ngcontent-c1="">Serial Number: %6$s</p></div>', $this->number, $dor, $this->expiryDate->format('d-m-Y'), $pCat, $product->getName(), $this->productSerialNumber);
		$bc                 = str_replace('{product_details}', $productDetailsHtml, $bc);
		
		return [ 'recipient' => $this->customer->getEmail(), 'subject' => $mt->getSubject(), 'body' => $bc ];
	}
	
	public
	function getDecisionStatus(): string {
		return $this->status;
	}
	
	public
	function makeDecision(
		string $decision
	) {
		$status = null;
        if($decision === DecisionMakingInterface::DECISION_RESET) {
            $status = DecisionMakingInterface::STATUS_NEW;
        } elseif($decision === DecisionMakingInterface::DECISION_APPROVE) {
			$status = DecisionMakingInterface::STATUS_APPROVED;
		} elseif($decision === DecisionMakingInterface::DECISION_REJECT) {
			$status = DecisionMakingInterface::STATUS_REJECTED;
		}
		if(empty($status)) {
			return;
		}
		$this->markStatusAs($status);
	}
	
	public
	function markStatusAs(
		$status
	) {
		switch($status) {
			case DecisionMakingInterface::STATUS_NEW:
				$this->new      = true;
				$this->approved = null;
				$this->rejected = null;
				$this->enabled  = false;
				break;
			case DecisionMakingInterface::STATUS_APPROVED:
				$this->new      = false;
				$this->approved = true;
				$this->rejected = false;
				$this->enabled  = true;
				break;
			case DecisionMakingInterface::STATUS_REJECTED:
				$this->new      = false;
				$this->approved = false;
				$this->rejected = true;
				$this->enabled  = false;
				break;
			case DecisionMakingInterface::STATUS_EXPIRED:
				$today = new \DateTime();
				if($this->expiryDate < $today) {
					$this->new     = false;
					$this->expired = true;
					$this->enabled = false;
				}
				break;
		}
		$this->status = $status;
	}
	
	
	/**
	 * @param bool $new
	 */
	public
	function setNew(
		bool $new
	): void {
		$this->new = $new;
	}
	
	/**
	 * @param bool $expired
	 */
	public
	function setExpired(
		bool $expired
	): void {
		$this->expired = $expired;
		if($expired) {
			$this->markStatusAs(DecisionMakingInterface::STATUS_EXPIRED);
		}
	}
	
	/**
	 * @param bool $rejected
	 */
	public
	function setRejected(
		bool $rejected
	): void {
		$this->rejected = $rejected;
		if($rejected) {
			$this->markStatusAs(DecisionMakingInterface::STATUS_REJECTED);
		}
	}
	
	/**
	 * @param bool $approved
	 */
	public
	function setApproved(
		bool $approved
	): void {
		$this->approved = $approved;
		if($approved) {
			$this->markStatusAs(DecisionMakingInterface::STATUS_APPROVED);
		}
	}
	
	/**
	 * @param Product|null $product
	 */
	public
	function setProduct(
		?Product $product
	): void {
		$this->product                = $product;
		$this->warrantyPeriod         = $product->getWarrantyPeriod();
		$this->extendedWarrantyPeriod = $product->getExtendedWarrantyPeriod();
	}
	
	public
	function getOrganisation(): ?Organisation {
		return $this->customer->getOrganisation();
	}
	
	public
	function initiateNumber() {
		if(empty($this->number)) {
			if( ! empty($this->id)) {
				$now          = new \DateTime();
				$this->number = $now->format('ym');
				$this->number .= '-' . User::generateCharacterCode('' . $this->id, 5);
			}
		}
		
		return $this->number;
	}
	
	/**
	 * @return int|null
	 */
	public
	function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", mappedBy="warranty", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected
		$cases;
	
	public
	function addCase(
		WarrantyCase $case
	) {
		$this->cases->add($case);
		$case->setWarranty($this);
	}
	
	public
	function removeCase(
		WarrantyCase $case
	) {
		$this->cases->removeElement($case);
		$case->setWarranty(null);
	}
	
	/**
	 * @var Customer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_customer", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$customer;
	
	/**
	 * @var Registration|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_registration", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected
		$registration;
	
	/**
	 * @var Product|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_product", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$product;
	
	/**
	 * @var Dealer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_dealer", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected
		$dealer;
	
	/**
	 * @var Collection|null
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="receiptImageWarranty", cascade={"persist","merge"},orphanRemoval=true)
	 */
	protected
		$receiptImages;
	
	public
	function addReceiptImage(
		Media $image
	) {
		$this->receiptImages->add($image);
		$image->setReceiptImageWarranty($this);
	}
	
	public
	function removeReceiptImage(
		Media $image
	) {
		$this->receiptImages->removeElement($image);
		$image->setReceiptImageWarranty(null);
	}
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime",nullable=true)
	 */
	protected
		$purchaseDate;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime",nullable=true)
	 */
	protected
		$expiryDate;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected
		$createdAt;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $warrantyApprovalNotified = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$extendedWarrantyPeriodApproved = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$approved = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$rejected = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$enabled = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$expired = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected
		$new = true;
	
	/**
	 * in months
	 * @var integer|null
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected
		$warrantyPeriod;
	
	/**
	 * @var integer|null
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected
		$extendedWarrantyPeriod;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $description;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$dealerName;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string")
	 */
	protected
		$code;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected
		$decisionRemarks;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", options={"default":"NEW"})
	 */
	protected
		$status = DecisionMakingInterface::STATUS_NEW;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$productSerialNumber;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$number;
	
	/**
	 * @return Customer|null
	 */
	public
	function getCustomer(): ?Customer {
		return $this->customer;
	}
	
	/**
	 * @param Customer|null $customer
	 */
	public
	function setCustomer(
		?Customer $customer
	): void {
		$this->customer = $customer;
	}
	
	/**
	 * @return Dealer|null
	 */
	public
	function getDealer(): ?Dealer {
		return $this->dealer;
	}
	
	/**
	 * @param Dealer|null $dealer
	 */
	public
	function setDealer(
		?Dealer $dealer
	): void {
		$this->dealer = $dealer;
	}
	
	/**
	 * @return Product|null
	 */
	public
	function getProduct(): ?Product {
		return $this->product;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public
	function getPurchaseDate(): ?\DateTime {
		return $this->purchaseDate;
	}
	
	/**
	 * @param \DateTime|null $purchaseDate
	 */
	public
	function setPurchaseDate(
		?\DateTime $purchaseDate
	): void {
		$this->purchaseDate = $purchaseDate;
	}
	
	/**
	 * @return \DateTime
	 */
	public
	function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public
	function setCreatedAt(
		\DateTime $createdAt
	): void {
		$this->createdAt = $createdAt;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getProductSerialNumber(): ?string {
		return $this->productSerialNumber;
	}
	
	/**
	 * @param null|string $productSerialNumber
	 */
	public
	function setProductSerialNumber(
		?string $productSerialNumber
	): void {
		$this->productSerialNumber = $productSerialNumber;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getNumber(): ?string {
		return $this->number;
	}
	
	/**
	 * @param null|string $number
	 */
	public
	function setNumber(
		?string $number
	): void {
		$this->number = $number;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public
	function getExpiryDate(): ?\DateTime {
		return $this->expiryDate;
	}
	
	/**
	 * @param \DateTime|null $expiryDate
	 */
	public
	function setExpiryDate(
		?\DateTime $expiryDate
	): void {
		$this->expiryDate = $expiryDate;
	}
	
	/**
	 * @return int|null
	 */
	public
	function getWarrantyPeriod(): ?int {
		return $this->warrantyPeriod;
	}
	
	/**
	 * @param int|null $warrantyPeriod
	 */
	public
	function setWarrantyPeriod(
		?int $warrantyPeriod
	): void {
		$this->warrantyPeriod = $warrantyPeriod;
	}
	
	/**
	 * @return int|null
	 */
	public
	function getExtendedWarrantyPeriod(): ?int {
		return $this->extendedWarrantyPeriod;
	}
	
	/**
	 * @param int|null $extendedWarrantyPeriod
	 */
	public
	function setExtendedWarrantyPeriod(
		?int $extendedWarrantyPeriod
	): void {
		$this->extendedWarrantyPeriod = $extendedWarrantyPeriod;
	}
	
	/**
	 * @return bool
	 */
	public
	function isApproved(): bool {
		return $this->approved;
	}
	
	/**
	 * @return Collection|null
	 */
	public
	function getReceiptImages(): ?Collection {
		return $this->receiptImages;
	}
	
	/**
	 * @param Collection|null $receiptImages
	 */
	public
	function setReceiptImages(
		?Collection $receiptImages
	): void {
		$this->receiptImages = $receiptImages;
	}
	
	
	/**
	 * @return Registration|null
	 */
	public
	function getRegistration(): ?Registration {
		return $this->registration;
	}
	
	/**
	 * @param Registration|null $registration
	 */
	public
	function setRegistration(
		?Registration $registration
	): void {
		$this->registration = $registration;
	}
	
	/**
	 * @return Collection
	 */
	public
	function getCases(): Collection {
		return $this->cases;
	}
	
	/**
	 * @param Collection $cases
	 */
	public
	function setCases(
		Collection $cases
	): void {
		$this->cases = $cases;
	}
	
	/**
	 * @return bool
	 */
	public
	function isRejected(): bool {
		return $this->rejected;
	}
	
	/**
	 * @return bool
	 */
	public
	function isEnabled(): bool {
		return $this->enabled;
	}
	
	/**
	 * @param bool $enabled
	 */
	public
	function setEnabled(
		bool $enabled
	): void {
		$this->enabled = $enabled;
	}
	
	/**
	 * @return bool
	 */
	public
	function isExpired(): bool {
		return $this->expired;
	}
	
	/**
	 * @return bool
	 */
	public
	function isNew(): bool {
		return $this->new;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getStatus(): ?string {
		return $this->status;
	}
	
	/**
	 * @param null|string $status
	 */
	public
	function setStatus(
		?string $status
	): void {
		$this->status = $status;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getCode(): ?string {
		return $this->code;
	}
	
	/**
	 * @param null|string $code
	 */
	public
	function setCode(
		?string $code
	): void {
		$this->code = $code;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getDecisionRemarks(): ?string {
		return $this->decisionRemarks;
	}
	
	/**
	 * @param null|string $decisionRemarks
	 */
	public
	function setDecisionRemarks(
		?string $decisionRemarks
	): void {
		$this->decisionRemarks = $decisionRemarks;
	}
	
	/**
	 * @return bool
	 */
	public function isExtendedWarrantyPeriodApproved(): bool {
		return $this->extendedWarrantyPeriodApproved;
	}
	
	/**
	 * @param bool $extendedWarrantyPeriodApproved
	 */
	public function setExtendedWarrantyPeriodApproved(bool $extendedWarrantyPeriodApproved): void {
		$this->extendedWarrantyPeriodApproved = $extendedWarrantyPeriodApproved;
	}
	
	/**
	 * @return null|string
	 */
	public function getDealerName(): ?string {
		return $this->dealerName;
	}
	
	/**
	 * @param null|string $dealerName
	 */
	public function setDealerName(?string $dealerName): void {
		$this->dealerName = $dealerName;
	}
	
	/**
	 * @return null|string
	 */
	public function getDescription(): ?string {
		return $this->description;
	}
	
	/**
	 * @param null|string $description
	 */
	public function setDescription(?string $description): void {
		$this->description = $description;
	}
	
	/**
	 * @return bool
	 */
	public function isWarrantyApprovalNotified(): bool {
		return $this->warrantyApprovalNotified;
	}
	
	/**
	 * @param bool $warrantyApprovalNotified
	 */
	public function setWarrantyApprovalNotified(bool $warrantyApprovalNotified): void {
		$this->warrantyApprovalNotified = $warrantyApprovalNotified;
	}
}
