<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACModuleInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="system__module")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * ORM\DiscriminatorMap({"person" = "Person", "employee" = "Employee"})
 */
abstract class SystemModule implements ACModuleInterface {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	
	function __construct() {
		$this->acEntries = new ArrayCollection();
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry", mappedBy="module", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $acEntries;
	
	/**
	 * @var System
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\System\System", inversedBy="modules", cascade={"persist","merge"})
	 * @ORM\JoinColumn(name="id_system", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $system;
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @return System
	 */
	public function getSystem(): System {
		return $this->system;
	}
	
	/**
	 * @param System $system
	 */
	public function setSystem(System $system): void {
		$this->system = $system;
	}
	
	/**
	 * @return Collection
	 */
	public function getAcEntries(): Collection {
		return $this->acEntries;
	}
	
	/**
	 * @param Collection $acEntries
	 */
	public function setAcEntries(Collection $acEntries): void {
		$this->acEntries = $acEntries;
	}
	
	
}