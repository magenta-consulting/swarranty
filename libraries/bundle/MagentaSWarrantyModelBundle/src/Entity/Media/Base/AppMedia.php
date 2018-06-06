<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Base;

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
	 * @var Organisation
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="logo")
	 * @ORM\JoinColumn(name="id_logo_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $logoOrganisation;
	
	/**
	 * @var Brand
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand", inversedBy="logo")
	 * @ORM\JoinColumn(name="id_logo_brand", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $logoBrand;
	
	/**
	 * @var Product
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product", inversedBy="image")
	 * @ORM\JoinColumn(name="id_image_product", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $imageProduct;
	
	/**
	 * Get id
	 *
	 * @return int $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return Organisation
	 */
	public function getLogoOrganisation() {
		return $this->logoOrganisation;
	}
	
	/**
	 * @param Organisation $logoOrganisation
	 */
	public function setLogoOrganisation($logoOrganisation) {
		$this->logoOrganisation = $logoOrganisation;
	}
	
	/**
	 * @return Organisation
	 */
	public function getLogoBrand(): Organisation {
		return $this->logoBrand;
	}
	
	/**
	 * @param Organisation $logoBrand
	 */
	public function setLogoBrand(Organisation $logoBrand): void {
		$this->logoBrand = $logoBrand;
	}
	
	/**
	 * @return Product
	 */
	public function getImageProduct(): Product {
		return $this->imageProduct;
	}
	
	/**
	 * @param Product $imageProduct
	 */
	public function setImageProduct(Product $imageProduct): void {
		$this->imageProduct = $imageProduct;
	}
}