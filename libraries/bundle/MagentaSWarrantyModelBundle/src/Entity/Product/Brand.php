<?php
namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__brand")
 */
class Brand extends Thing {
	
	function __construct() {
		$this->categories = new ArrayCollection();
		$this->subCategories = new ArrayCollection();
		$this->suppliers = new ArrayCollection();
	}
	
	/**
	 * @var Collection
	 * @ORM\ManyToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory", mappedBy="brands", cascade={"persist","merge"})
	 */
	protected $categories;
	
	/**
	 * @var Collection
	 * @ORM\ManyToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSubCategory", mappedBy="brands", cascade={"persist","merge"})
	 */
	protected $subCategories;
	
	/**
	 * @var Collection
	 * @ORM\ManyToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSupplier", mappedBy="brands", cascade={"persist","merge"})
	 */
	protected $suppliers;
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="brands", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @var Media|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="logoBrand", cascade={"persist","merge"})
	 */
	protected $logo;
	
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
	 * @return Organisation|null
	 */
	public function getOrganisation(): ?Organisation {
		return $this->organisation;
	}
	
	/**
	 * @param Organisation|null $organisation
	 */
	public function setOrganisation(?Organisation $organisation): void {
		$this->organisation = $organisation;
	}
	
	/**
	 * @return Media|null
	 */
	public function getLogo(): ?Media {
		return $this->logo;
	}
	
	/**
	 * @param Media|null $logo
	 */
	public function setLogo(?Media $logo): void {
		$this->logo = $logo;
	}
}