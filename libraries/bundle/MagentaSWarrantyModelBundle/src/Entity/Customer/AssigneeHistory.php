<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__assignee_history")
 */
class AssigneeHistory {
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	public function __construct() {
		$this->createdAt = new \DateTime();
	}
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var WarrantyCase|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", cascade={"persist", "merge"}, inversedBy="assigneeHistory")
	 * @ORM\JoinColumn(name="id_case", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $case;
	
	/**
	 * @var OrganisationMember|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", cascade={"persist", "merge"}, inversedBy="assigneeHistory")
	 * @ORM\JoinColumn(name="id_assignee", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $assignee;
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $assigneeName;
	
	/**
	 * @return WarrantyCase|null
	 */
	public function getCase(): ?WarrantyCase {
		return $this->case;
	}
	
	/**
	 * @param WarrantyCase|null $case
	 */
	public function setCase(?WarrantyCase $case): void {
		$this->case = $case;
	}
	
	/**
	 * @return OrganisationMember|null
	 */
	public function getAssignee(): ?OrganisationMember {
		return $this->assignee;
	}
	
	/**
	 * @param OrganisationMember|null $assignee
	 */
	public function setAssignee(?OrganisationMember $assignee): void {
		$this->assignee = $assignee;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt(\DateTime $createdAt): void {
		$this->createdAt = $createdAt;
	}
	
	/**
	 * @return null|string
	 */
	public function getAssigneeName(): ?string {
		return $this->assigneeName;
	}
	
	/**
	 * @param null|string $assigneeName
	 */
	public function setAssigneeName(?string $assigneeName): void {
		$this->assigneeName = $assigneeName;
	}
}