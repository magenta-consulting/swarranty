<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation;

use Bean\Component\Organization\Model\OrganizationMember as MemberModel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;

/**
 * @ORM\Entity()
 * @ORM\Table(name="organisation__member")
 */
class OrganisationMember extends MemberModel {
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
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory", cascade={"persist", "merge"}, mappedBy="assignee")
	 */
	protected $assigneeHistory;
	
	public function addAssigneeHistory(AssigneeHistory $ah) {
		$this->assigneeHistory->add($ah);
		$ah->setAssignee($this);
	}
	
	public function removeAssigneeHistory(AssigneeHistory $ah) {
		$this->assigneeHistory->removeElement($ah);
		$ah->setAssignee(null);
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", mappedBy="assignee", cascade={"persist","merge"})
	 */
	protected $cases;
	
	public function addCase(WarrantyCase $case) {
		$this->cases->add($case);
		$case->setAssignee($this);
	}
	
	public function removeCase(WarrantyCase $case) {
		$this->cases->removeElement($case);
		$case->setAssignee(null);
	}
	
	/**
	 * @var Organisation|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="members")
	 * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $organization;
	
	/**
	 * @var Person|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person", inversedBy="members", cascade={"merge", "persist"})
	 * @ORM\JoinColumn(name="id_person", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $person;
	
	/**
	 * @var ACRole|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole", inversedBy="members")
	 * @ORM\JoinColumn(name="id_role", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $role;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean")
	 */
	protected $enabled = true;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean")
	 */
	protected $contactable = true;
	
	/**
	 * @return bool
	 */
	public function isContactable(): bool {
		return $this->contactable;
	}
	
	/**
	 * @param bool $contactable
	 */
	public function setContactable(bool $contactable): void {
		$this->contactable = $contactable;
	}
	
	/**
	 * @return ACRole|null
	 */
	public function getRole(): ?ACRole {
		return $this->role;
	}
	
	/**
	 * @param ACRole|null $role
	 */
	public function setRole(?ACRole $role): void {
		$this->role = $role;
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