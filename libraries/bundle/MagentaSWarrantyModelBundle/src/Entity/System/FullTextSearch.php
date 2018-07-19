<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * Class FullTextSearch
 * @package Magenta\Bundle\SWarrantyModelBundle\Entity\System
 * @ORM\MappedSuperclass()
 */
abstract class FullTextSearch implements FullTextSearchInterface, OrganisationAwareInterface {
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $searchText;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="text", nullable=true)
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
	
}