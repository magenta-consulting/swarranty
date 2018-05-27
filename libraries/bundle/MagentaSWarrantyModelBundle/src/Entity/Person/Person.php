<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Person;

use \Bean\Component\Person\Model\Person as PersonModel;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="person__person")
 */
class Person extends PersonModel {
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var User|null
	 * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\User\User", mappedBy="person")
	 */
	protected $user;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $name;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $birthDate;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $givenName;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $familyName;
	
	/**
	 * @return User|null
	 */
	public function getUser(): ?User {
		return $this->user;
	}
	
	/**
	 * @param User|null $user
	 */
	public function setUser(?User $user): void {
		$this->user = $user;
	}
	
}