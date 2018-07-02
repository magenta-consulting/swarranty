<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Bean\Component\Thing\Model\ThingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * Class Thing
 * @package Magenta\Bundle\SWarrantyModelBundle\Entity\System
 * @ORM\MappedSuperclass()
 */
abstract class Thing extends FullTextSearch {
	
	public function generateSearchText() {
		return $this->searchText = $this->name . sprintf(' (%s)', $this->enabled ? 'enabled' : 'disabled');
	}
	
	public function generateFullText() {
		$org            = $this->getOrganisation();
		$orgName        = $org === null ? 'none' : $org->getName();
		return $this->fullText = sprintf('name:%s %s org:%s', $this->name, $this->enabled ? 'enabled' : 'disabled', $orgName);
	}
	
	
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
	
	public function isGranted($action, User $user) {
		return true;
	}
	
	/**
	 * @var Organisation|null
	 */
	protected $organisation;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected $enabled = true;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string")
	 */
	protected $name;
	
	/**
	 * @return null|string
	 */
	public function getName(): ?string {
		return $this->name;
	}
	
	/**
	 * @param null|string $name
	 */
	public function setName(?string $name): void {
		$this->name = $name;
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
	
	/**
	 * @return Organisation|null
	 */
	public function getOrganisation(): ?Organisation {
		return $this->organisation;
	}
	
	/**
	 * @param Organisation|null $organisation
	 */
	public function setOrganisation(?Organisation $organisation): void {
		$this->organisation = $organisation;
	}
	
}