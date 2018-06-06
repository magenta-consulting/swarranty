<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__subcategory")
 */
class BrandSubCategory extends Thing {
	
	/**
	 * @var Collection|null
	 * @ORM\ManyToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", inversedBy="subCategories", cascade={"persist","merge"})
	 * @ORM\JoinTable(name="product__subcategories_brands",
	 *      joinColumns={@ORM\JoinColumn(name="id_subcategory", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="id_brand", referencedColumnName="id")}
	 *      )
	 */
	protected $brands;
	
	public function addBrand(Brand $brand) {
		$this->brands->add($brand);
	}
	
	public function removeBrand(Brand $brand) {
		$this->brands->removeElement($brand);
	}
	
	
	/**
	 * @var Collection|null
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product", mappedBy="subCategory", cascade={"persist","merge"})
	 */
	protected $products;
	
	public function addProduct(Product $product) {
		$this->products->add($product);
		$product->setSubCategory($this);
	}
	
	public function removeProduct(Product $product) {
		$this->products->removeElement($product);
		$product->setSubCategory(null);
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="subCategories", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @return Collection|null
	 */
	public function getProducts(): ?Collection {
		return $this->products;
	}
	
	/**
	 * @param Collection|null $products
	 */
	public function setProducts(?Collection $products): void {
		$this->products = $products;
	}
}