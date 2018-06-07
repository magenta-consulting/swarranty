<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="product__zone")
 */
class ServiceZone extends Thing {
	
	public function __construct() {
		$this->cases = new ArrayCollection();
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", mappedBy="serviceZone", cascade={"persist","merge"})
	 */
	protected $cases;
	
	public function addCase(WarrantyCase $case) {
		$this->cases->add($case);
		$case->setServiceZone($this);
	}
	
	public function removeCase(WarrantyCase $case) {
		$this->cases->removeElement($case);
		$case->setServiceZone(null);
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="serviceZones", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @return Collection
	 */
	public function getCases(): Collection {
		return $this->cases;
	}
	
	/**
	 * @param Collection $cases
	 */
	public function setCases(Collection $cases): void {
		$this->cases = $cases;
	}
}