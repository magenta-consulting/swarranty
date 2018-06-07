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
 * @ORM\Table(name="customer__case")
 */
class WarrantyCase {
	
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
	
	public function initiateNumber() {
		if(empty($this->number)) {
			$now          = new \DateTime();
			$this->number = User::generateCharacterCode();
			if( ! empty($this->purchaseDate)) {
				$this->number .= '-' . $this->purchaseDate->format('my');
			} else {
				$this->number .= '-' . 'XXXX';
			}
			$this->number .= '-' . $now->format('my');
		}
	}
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceNote", mappedBy="case", cascade={"persist","merge"},orphanRemoval=true)
	 */
	protected $serviceNotes;
	
	public function addServiceNote(ServiceNote $note) {
		$this->serviceNotes->add($note);
		$note->setCase($this);
	}
	
	public function removeServiceNote(ServiceNote $note) {
		$this->serviceNotes->removeElement($note);
		$note->setCase(null);
	}
	
	/**
	 * @var Warranty|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", cascade={"persist", "merge"}, inversedBy="cases")
	 * @ORM\JoinColumn(name="id_warranty", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $warranty;
	
	/**
	 * @var ServiceZone|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone", cascade={"persist", "merge"}, inversedBy="cases")
	 * @ORM\JoinColumn(name="id_service_zone", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $serviceZone;
	
	/**
	 * @var OrganisationMember|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", cascade={"persist", "merge"}, inversedBy="cases")
	 * @ORM\JoinColumn(name="id_assignee", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected $assignee;
	
	
	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory", cascade={"persist", "merge"}, mappedBy="case")
	 */
	protected $assigneeHistory;
	
	public function addAssigneeHistory(AssigneeHistory $ah) {
		$this->assigneeHistory->add($ah);
		$ah->setCase($this);
	}
	
	public function removeAssigneeHistory(AssigneeHistory $ah) {
		$this->assigneeHistory->removeElement($ah);
		$ah->setCase(null);
	}
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $closedAt;
	
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $number;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected $description;
	
	/**
	 * @return Warranty|null
	 */
	public function getWarranty(): ?Warranty {
		return $this->warranty;
	}
	
	/**
	 * @param Warranty|null $warranty
	 */
	public function setWarranty(?Warranty $warranty): void {
		$this->warranty = $warranty;
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
	public function getNumber(): ?string {
		return $this->number;
	}
	
	/**
	 * @param null|string $number
	 */
	public function setNumber(?string $number): void {
		$this->number = $number;
	}
	
	/**
	 * @return ServiceZone|null
	 */
	public function getServiceZone(): ?ServiceZone {
		return $this->serviceZone;
	}
	
	/**
	 * @param ServiceZone|null $serviceZone
	 */
	public function setServiceZone(?ServiceZone $serviceZone): void {
		$this->serviceZone = $serviceZone;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public function getClosedAt(): ?\DateTime {
		return $this->closedAt;
	}
	
	/**
	 * @param \DateTime|null $closedAt
	 */
	public function setClosedAt(?\DateTime $closedAt): void {
		$this->closedAt = $closedAt;
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
	 * @return null|string
	 */
	public function getDescription(): ?string {
		return $this->description;
	}
	
	/**
	 * @param null|string $description
	 */
	public function setDescription(?string $description): void {
		$this->description = $description;
	}
}