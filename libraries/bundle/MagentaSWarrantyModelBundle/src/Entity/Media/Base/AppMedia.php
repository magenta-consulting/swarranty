<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Base;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Sonata\MediaBundle\Entity\BaseMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/** @ORM\MappedSuperclass */
class AppMedia extends BaseMedia {
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	function __construct() {
		$this->enabled = true;
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="logo")
	 * @ORM\JoinColumn(name="id_logo_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $logoOrganisation;
	
	/**
	 * @var Brand|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", inversedBy="logo")
	 * @ORM\JoinColumn(name="id_logo_brand", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $logoBrand;
	
	/**
	 * @var Product|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product", inversedBy="image")
	 * @ORM\JoinColumn(name="id_image_product", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $imageProduct;
	
	/**
	 * @var Warranty|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", inversedBy="receiptImages")
	 * @ORM\JoinColumn(name="id_receipt_image_warranty", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $receiptImageWarranty;
	
	/**
	 * @var ServiceSheet|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet", inversedBy="images")
	 * @ORM\JoinColumn(name="id_image_service_sheet", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $imageServiceSheet;
	
	/**
	 * Get id
	 *
	 * @return int $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return Organisation|null
	 */
	public function getLogoOrganisation(): ?Organisation {
		return $this->logoOrganisation;
	}
	
	/**
	 * @param Organisation|null $logoOrganisation
	 */
	public function setLogoOrganisation(?Organisation $logoOrganisation): void {
		$this->logoOrganisation = $logoOrganisation;
	}
	
	/**
	 * @return Brand|null
	 */
	public function getLogoBrand(): ?Brand {
		return $this->logoBrand;
	}
	
	/**
	 * @param Brand|null $logoBrand
	 */
	public function setLogoBrand(?Brand $logoBrand): void {
		$this->logoBrand = $logoBrand;
	}
	
	/**
	 * @return Product|null
	 */
	public function getImageProduct(): ?Product {
		return $this->imageProduct;
	}
	
	/**
	 * @param Product|null $imageProduct
	 */
	public function setImageProduct(?Product $imageProduct): void {
		$this->imageProduct = $imageProduct;
	}
	
	/**
	 * @return Warranty|null
	 */
	public function getReceiptImageWarranty(): ?Warranty {
		return $this->receiptImageWarranty;
	}
	
	/**
	 * @param Warranty|null $receiptImageWarranty
	 */
	public function setReceiptImageWarranty(?Warranty $receiptImageWarranty): void {
		$this->receiptImageWarranty = $receiptImageWarranty;
	}
	
	/**
	 * @return ServiceSheet|null
	 */
	public function getImageServiceSheet(): ?ServiceSheet {
		return $this->imageServiceSheet;
	}
	
	/**
	 * @param ServiceSheet|null $imageServiceSheet
	 */
	public function setImageServiceSheet(?ServiceSheet $imageServiceSheet): void {
		$this->imageServiceSheet = $imageServiceSheet;
	}
}