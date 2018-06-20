<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * Class Thing
 * @package Magenta\Bundle\SWarrantyModelBundle\Entity\System
 * @ORM\MappedSuperclass()
 */
abstract class Thing implements FullTextSearchInterface {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	public function generateSearchText() {
		$this->searchText = $this->name . sprintf(' (%s)', $this->enabled ? 'enabled' : 'disabled');
	}
	
	public function generateFullText() {
		$orgName        = $this->organisation === null ? 'none' : $this->organisation->getName();
		$this->fullText = sprintf('name:%s %s org:%s', $this->name, $this->enabled ? 'enabled' : 'disabled', $orgName);
	}
	
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
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $searchText;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $fullText;
	
	public function setFullText(?string $text): void {
		$this->fullText = $text;
	}
	
	public function getFullText() {
		return $this->fullText;
	}
	
	/**
	 * @return null|string
	 */
	public function getSearchText(): ?string {
		return $this->searchText;
	}
	
	/**
	 * @param null|string $searchText
	 */
	public function setSearchText(?string $searchText): void {
		$this->searchText = $searchText;
	}
	
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