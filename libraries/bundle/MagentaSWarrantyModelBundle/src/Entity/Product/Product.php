<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__product")
 */
class Product extends Thing {
	
	function __construct() {
	}
	
	public function generateSearchText() {
		$subcat = empty($this->subCategory) ? 'No Sub-Category' : $this->subCategory->getName();
		$cat    = empty($this->category) ? 'No Sub-Category' : $this->category->getName();
		$brand  = empty($this->brand) ? 'No Sub-Category' : $this->brand->getName();
		
		$this->searchText = $this->name . sprintf(' (%s) ', $this->modelNumber) . sprintf(' %s < %s ( %s ) ', $subcat, $cat, $brand);
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", mappedBy="product", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $warranties;
	
	public function addWarranty(Warranty $warranty) {
		$this->warranties->add($warranty);
		$warranty->setProduct($this);
	}
	
	public function removeWarranty(Warranty $warranty) {
		$this->warranties->removeElement($warranty);
		$warranty->setProduct(null);
	}
	
	/**
	 * @var BrandCategory|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory", inversedBy="products", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_category", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $category;
	
	/**
	 * @var BrandSubCategory|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSubCategory", inversedBy="products", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_subcategory", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $subCategory;
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="brands", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @var Brand|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", inversedBy="products", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_brand", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $brand;
	
	/**
	 * @var Media|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="imageProduct", cascade={"persist","merge"})
	 */
	protected $image;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $searchText;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $modelNumber;
	
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
	 * @return BrandCategory|null
	 */
	public function getCategory(): ?BrandCategory {
		return $this->category;
	}
	
	/**
	 * @param BrandCategory|null $category
	 */
	public function setCategory(?BrandCategory $category): void {
		$this->category = $category;
	}
	
	/**
	 * @return BrandSubCategory|null
	 */
	public function getSubCategory(): ?BrandSubCategory {
		return $this->subCategory;
	}
	
	/**
	 * @param BrandSubCategory|null $subCategory
	 */
	public function setSubCategory(?BrandSubCategory $subCategory): void {
		$this->subCategory = $subCategory;
	}
	
	/**
	 * @return Brand|null
	 */
	public function getBrand(): ?Brand {
		return $this->brand;
	}
	
	/**
	 * @param Brand|null $brand
	 */
	public function setBrand(?Brand $brand): void {
		$this->brand = $brand;
	}
	
	/**
	 * @return Media|null
	 */
	public function getImage(): ?Media {
		return $this->image;
	}
	
	/**
	 * @param Media|null $image
	 */
	public function setImage(?Media $image): void {
		$this->image = $image;
	}
	
	/**
	 * @return null|string
	 */
	public function getModelNumber(): ?string {
		return $this->modelNumber;
	}
	
	/**
	 * @param null|string $modelNumber
	 */
	public function setModelNumber(?string $modelNumber): void {
		$this->modelNumber = $modelNumber;
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
	 * @return null|string
	 */
	public function getSearchText(): ?string {
		return $this->searchText;
	}
	
	/**
	 * @param null|string $searchText
	 */
	public function setSearchText(?string $searchText): void {
		$this->searchText = $searchText;
	}
}