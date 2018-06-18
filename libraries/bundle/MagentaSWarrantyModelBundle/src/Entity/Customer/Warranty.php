<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
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
 * @ORM\Table(name="customer__warranty")
 */
class Warranty implements ThingChildInterface {
	
	const STATUS_NEW = 'NEW';
	const STATUS_EXPIRED = 'EXPIRED';
	const STATUS_REJECTED = 'REJECTED';
	const STATUS_APPROVED = 'APPROVED';
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	public function __construct() {
		$this->cases = new ArrayCollection();
		
		$this->createdAt = new \DateTime();
	}
	
	/**
	 * @param Media|null $receiptImage
	 */
	public function setReceiptImage(?Media $receiptImage): void {
		if( ! empty($receiptImage)) {
			$receiptImage->setReceiptImageWarranty($this);
		}
		if( ! empty($this->receiptImage)) {
			$this->receiptImage->setReceiptImageWarranty(null);
		}
		$this->receiptImage = $receiptImage;
	}
	
	public function markStatusAs($status) {
		switch($status) {
			case self::STATUS_NEW:
				$this->new     = true;
				$this->enabled = false;
				break;
			case self::STATUS_APPROVED:
				$this->new      = false;
				$this->approved = true;
				$this->rejected = false;
				$this->enabled  = true;
				break;
			case self::STATUS_REJECTED:
				$this->new      = false;
				$this->approved = false;
				$this->rejected = true;
				$this->enabled  = false;
				break;
			case self::STATUS_EXPIRED:
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
	 * @param Product|null $product
	 */
	public function setProduct(?Product $product): void {
		$this->product                = $product;
		$this->warrantyPeriod         = $product->getWarrantyPeriod();
		$this->extendedWarrantyPeriod = $product->getWarrantyPeriod();
	}
	
	public function getOrganisation(): Organisation {
		return $this->customer->getOrganisation();
	}
	
	public function initiateNumber() {
		if(empty($this->number)) {
			$now          = new \DateTime();
			$this->number = User::generateCharacterCode();
			if( ! empty($this->purchaseDate)) {
				$this->number .= '-' . $this->purchaseDate->format('my');
			} else {
				$this->number .= '-' . 'XXXX';
			}
			$this->number .= '-' . $now->format('my');
		}
	}
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", mappedBy="warranty", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $cases;
	
	public function addCase(WarrantyCase $case) {
		$this->cases->add($case);
		$case->setWarranty($this);
	}
	
	public function removeCase(WarrantyCase $case) {
		$this->cases->removeElement($case);
		$case->setWarranty(null);
	}
	
	/**
	 * @var Customer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_customer", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $customer;
	
	/**
	 * @var Customer|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration", cascade={"persist", "merge"}, inversedBy="warranties")
	 * @ORM\JoinColumn(name="id_registration", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $registration;
	
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
	 * @var Media|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="receiptImageWarranty", cascade={"persist","merge"})
	 */
	protected $receiptImage;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime",nullable=true)
	 */
	protected $purchaseDate;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime",nullable=true)
	 */
	protected $expiryDate;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $approved = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $rejected = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $enabled = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected $expired = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $new = true;
	
	/**
	 * in months
	 * @var integer|null
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $warrantyPeriod;
	
	/**
	 * @var integer|null
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $extendedWarrantyPeriod;
	
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", options={"default":"NEW"})
	 */
	protected $status = self::STATUS_NEW;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $productSerialNumber;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $number;
	
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
	 * @return \DateTime|null
	 */
	public function getPurchaseDate(): ?\DateTime {
		return $this->purchaseDate;
	}
	
	/**
	 * @param \DateTime|null $purchaseDate
	 */
	public function setPurchaseDate(?\DateTime $purchaseDate): void {
		$this->purchaseDate = $purchaseDate;
	}
	
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
	 * @return null|string
	 */
	public function getProductSerialNumber(): ?string {
		return $this->productSerialNumber;
	}
	
	/**
	 * @param null|string $productSerialNumber
	 */
	public function setProductSerialNumber(?string $productSerialNumber): void {
		$this->productSerialNumber = $productSerialNumber;
	}
	
	/**
	 * @return null|string
	 */
	public function getNumber(): ?string {
		return $this->number;
	}
	
	/**
	 * @param null|string $number
	 */
	public function setNumber(?string $number): void {
		$this->number = $number;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public function getExpiryDate(): ?\DateTime {
		return $this->expiryDate;
	}
	
	/**
	 * @param \DateTime|null $expiryDate
	 */
	public function setExpiryDate(?\DateTime $expiryDate): void {
		$this->expiryDate = $expiryDate;
	}
	
	/**
	 * @return int|null
	 */
	public function getWarrantyPeriod(): ?int {
		return $this->warrantyPeriod;
	}
	
	/**
	 * @param int|null $warrantyPeriod
	 */
	public function setWarrantyPeriod(?int $warrantyPeriod): void {
		$this->warrantyPeriod = $warrantyPeriod;
	}
	
	/**
	 * @return int|null
	 */
	public function getExtendedWarrantyPeriod(): ?int {
		return $this->extendedWarrantyPeriod;
	}
	
	/**
	 * @param int|null $extendedWarrantyPeriod
	 */
	public function setExtendedWarrantyPeriod(?int $extendedWarrantyPeriod): void {
		$this->extendedWarrantyPeriod = $extendedWarrantyPeriod;
	}
	
	/**
	 * @return bool
	 */
	public function isApproved(): bool {
		return $this->approved;
	}
	
	/**
	 * @param bool $approved
	 */
	public function setApproved(bool $approved): void {
		$this->approved = $approved;
	}
	
	/**
	 * @return Media|null
	 */
	public function getReceiptImage(): ?Media {
		return $this->receiptImage;
	}
	
}