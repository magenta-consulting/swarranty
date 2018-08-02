<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__category")
 */
class BrandCategory extends Thing {
	
	public function __construct() {
		$this->brands   = new ArrayCollection();
		$this->products = new ArrayCollection();
	}
	
	/**
	 * @return Collection|null
	 */
	public function getEnabledProducts(): ?Collection {
		$criteria = Criteria::create();
		$expr     = Criteria::expr();
		$criteria->andWhere($expr->eq('enabled', true));
		
		return $this->products->matching($criteria);
	}
	
	/**
	 * @var Collection|null
	 * @ORM\ManyToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", inversedBy="categories", cascade={"persist","merge"})
	 * @ORM\JoinTable(name="product__categories_brands",
	 *      joinColumns={@ORM\JoinColumn(name="id_category", referencedColumnName="id")},
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
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product", mappedBy="category", cascade={"persist","merge"})
	 */
	protected $products;
	
	public function addProduct(Product $product) {
		$this->products->add($product);
		$product->setCategory($this);
	}
	
	public function removeProduct(Product $product) {
		$this->products->removeElement($product);
		$product->setCategory(null);
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="categories", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @return Collection|null
	 */
	public function getBrands(): ?Collection {
		return $this->brands;
	}
	
	/**
	 * @param Collection|null $brands
	 */
	public function setBrands(?Collection $brands): void {
		$this->brands = $brands;
	}
	
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