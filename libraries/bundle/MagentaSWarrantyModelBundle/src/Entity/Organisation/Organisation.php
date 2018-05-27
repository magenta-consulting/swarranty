<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation;

use Bean\Component\Organization\Model\Organization as OrganizationModel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;

/**
 * @ORM\Entity()
 * @ORM\Table(name="organisation__organisation")
 */
class Organisation extends OrganizationModel {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * @var Media
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="logoOrganisation", cascade={"persist","merge"})
	 */
	protected $logo;
	
	/**
	 * @return Media
	 */
	public function getLogo(): Media {
		return $this->logo;
	}
	
	/**
	 * @param Media $logo
	 */
	public function setLogo(Media $logo): void {
		$this->logo = $logo;
	}
}