<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

/**
 * @ORM\Entity()
 * @ORM\Table(name="access__role")
 */
class ACRole extends Thing {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	function __construct() {
		$this->entries = new ArrayCollection();
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", mappedBy="role", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $members;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry", mappedBy="role", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $entries;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="roles", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organisation;
	
	/**
	 * @return Collection
	 */
	public function getEntries(): Collection {
		return $this->entries;
	}
	
	/**
	 * @param Collection $entries
	 */
	public function setEntries(Collection $entries): void {
		$this->entries = $entries;
	}
}