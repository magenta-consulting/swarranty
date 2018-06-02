<?php
namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__category")
 */
class BrandCategory extends Thing {
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", inversedBy="categories", cascade={"persist","merge"})
	 * @ORM\JoinTable(name="product__categories_brands",
	 *      joinColumns={@ORM\JoinColumn(name="id_category", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="id_brand", referencedColumnName="id")}
	 *      )	 */
	protected $brands;
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="categories", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
}