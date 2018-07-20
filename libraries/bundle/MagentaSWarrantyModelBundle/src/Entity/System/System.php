<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="system__system")
 */
class System {
	
	/**
	 * @var string
	 * @ORM\Id
	 * @ORM\Column(type="string", length=180)
	 */
	protected $id = 'magenta.swarranty';
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=255)
	 */
	protected $domain = 'magentapulse.com';
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule", mappedBy="system", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $modules;
	
	/**
	 * @param $code
	 *
	 * @return SystemModule|null
	 */
	public function getModuleByCode($code) {
		$code = strtoupper($code);
		/** @var SystemModule $module */
		foreach($this->modules as $module) {
			if($module->getModuleCode() === $code) {
				return $module;
			}
		}
		
		return null;
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", mappedBy="system", cascade={"persist","merge"}, orphanRemoval=true)
	 */
	protected $organisations;
	
	/**
	 * @var boolean
	 */
	protected $enabled;
	
	/**
	 * @return string
	 */
	public function getId(): string {
		return $this->id;
	}
	
	/**
	 * @param string $id
	 */
	public function setId(string $id): void {
		$this->id = $id;
	}
	
	/**
	 * @return Collection
	 */
	public function getModules(): Collection {
		return $this->modules;
	}
	
	/**
	 * @param Collection $modules
	 */
	public function setModules(Collection $modules): void {
		$this->modules = $modules;
	}
	
	/**
	 * @return Collection
	 */
	public function getOrganisations(): Collection {
		return $this->organisations;
	}
	
	/**
	 * @param Collection $organisations
	 */
	public function setOrganisations(Collection $organisations): void {
		$this->organisations = $organisations;
	}
	
	/**
	 * @return bool
	 */
	public function isEnabled(): bool {
		return $this->enabled;
	}
	
	/**
	 * @param bool $enabled
	 */
	public function setEnabled(bool $enabled): void {
		$this->enabled = $enabled;
	}
}