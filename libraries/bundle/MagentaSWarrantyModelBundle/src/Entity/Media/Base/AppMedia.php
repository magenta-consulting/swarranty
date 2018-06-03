<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Base;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
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
	 * @var Organisation
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="logo")
	 * @ORM\JoinColumn(name="id_logo_brand", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $logoBrand;
	
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
}