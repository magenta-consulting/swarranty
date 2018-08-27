<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Doctrine\DBAL\Exception\ConstraintViolationException;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearch;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity(repositoryClass="Magenta\Bundle\SWarrantyModelBundle\Repository\WarrantyCaseRepository")
 * @ORM\Table(name="customer__case")
 */
class WarrantyCase extends FullTextSearch implements DecisionMakingInterface {
	
	const PRIORITY_LOW = 'LOW';
	const PRIORITY_NORMAL = 'NORMAL';
	const PRIORITY_HIGH = 'HIGH';
	
	const DECISION_ASSIGN = 'ASSIGN';
	const DECISION_CLOSE = 'CLOSE';
	const DECISION_COMPLETE = 'COMPLETE';
	const DECISION_UNCOMPLETE = 'UNCOMPLETE';
	const DECISION_REOPEN = 'REOPEN';

//	const STATUS_NEW = 'NEW'; // inherited
	const STATUS_CLOSED = 'CLOSED';
	const STATUS_ASSIGNED = 'ASSIGNED';
	const STATUS_REOPENED = 'REOPENED';
	const STATUS_RESPONDED = 'RESPONDED';
	const STATUS_COMPLETED = 'COMPLETED';
	
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer",options={"unsigned":true})
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected
		$id;
	
	public
	function __construct() {
		$this->createdAt       = new \DateTime();
		$this->children        = new ArrayCollection();
		$this->appointments    = new ArrayCollection();
		$this->serviceSheets   = new ArrayCollection();
		$this->serviceNotes    = new ArrayCollection();
		$this->assigneeHistory = new ArrayCollection();
	}
	
	public function getCurrentAppointment() {
		if(empty($this->appointmentAt)) {
			return null;
		}
		/** @var CaseAppointment $apmt */
		foreach($this->appointments as $apmt) {
			if($apmt->getAppointmentAt()->format('d-m-Y H:i:s') === $this->getAppointmentAt()->format('d-m-Y H:i:s')) {
				return $apmt;
			}
		}
		
		return null;
	}
	
	public function getServiceNotesString() {
		$noteStr = '';
		/** @var ServiceNote $note */
		foreach($this->serviceNotes as $note) {
			$noteStr += $note->getDescription();
		}
		
		return $noteStr;
	}
	
	public function getAssigneeString() {
		$assigneeStr = '';
		if( ! empty($this->assignee) && ! empty($p = $this->assignee->getPerson())) {
			$assigneeStr = $p->getName();
		}
		
		return $assigneeStr;
	}
	
	public function getOrganisation(): ?Organisation {
		return $this->warranty->getOrganisation();
	}
	
	public function generateFullText() {
		$assigneeName = ' ';
		if( ! empty($this->assignee)) {
			$assigneeName .= $this->assignee->getPerson()->getName() . ' ';
		}
		
		return $this->fullText = 'case number:' . $this->number . $assigneeName . $this->warranty->getFullText();
	}
	
	public function generateSearchText() {
		return $this->searchText = $this->number . ' < ' . $this->warranty->getSearchText();
	}
	
	public
	function isWarrantyExpired() {
		$w       = $this->warranty;
		$expDate = $w->getExpiryDate();
		$now     = new \DateTime();
		
		return $expDate < $now;
	}
	
	public
	function getDecisionStatus(): string {
		return $this->status;
	}
	
	public
	function makeDecision(
		string $decision
	) {
		switch($decision) {
			case self::DECISION_ASSIGN:
				$this->markStatusAs(self::STATUS_ASSIGNED);
				break;
			case self::DECISION_COMPLETE:
				$this->markStatusAs(self::STATUS_COMPLETED);
				break;
			case self::DECISION_UNCOMPLETE:
				$this->markStatusAs(self::STATUS_RESPONDED);
				break;
			case self::DECISION_CLOSE:
				$this->markStatusAs(self::STATUS_CLOSED);
				break;
			case self::DECISION_REOPEN:
				$this->markStatusAs(self::STATUS_REOPENED);
				break;
		}
	}
	
	/**
	 * @return null|string
	 */
	public
	function getDecisionRemarks(): ?string {
		return $this->decisionRemarks;
	}
	
	/**
	 * @param null|string $decisionRemarks
	 */
	public
	function setDecisionRemarks(
		?string $decisionRemarks
	): void {
		$this->decisionRemarks = $decisionRemarks;
	}
	
	public
	function markStatusAs(
		$status
	) {
		switch($status) {
			case self::STATUS_NEW:
				$this->open      = true;
				$this->assigned  = false;
				$this->responded = false;
				$this->completed = false;
				$this->closed    = false;
				$this->status    = self::STATUS_NEW;
				break;
			
			case self::STATUS_ASSIGNED:
				$this->open      = true;
				$this->assigned  = true;
				$this->responded = false;
				$this->completed = false;
				$this->closed    = false;
				$this->status    = self::STATUS_ASSIGNED;
				break;
			
			case self::STATUS_RESPONDED:
				$this->open      = true;
				$this->assigned  = true;
				$this->responded = true;
				$this->completed = false;
				$this->closed    = false;
				$this->status    = self::STATUS_RESPONDED;
				$apmt            = $this->getCurrentAppointment();
				if( ! empty($apmt)) {
					if(empty($apmt->getVisitedAt())) {
						$apmt->setVisitedAt(new \DateTime());
					}
				}
				break;
			
			case self::STATUS_COMPLETED:
				$this->open      = true;
				$this->assigned  = true;
				$this->responded = true;
				$this->completed = true;
				$this->closed    = false;
				$this->status    = self::STATUS_COMPLETED;
				$apmt            = $this->getCurrentAppointment();
				if( ! empty($apmt)) {
					if(empty($apmt->getVisitedAt())) {
						$apmt->setVisitedAt(new \DateTime());
					}
				}
				break;
			
			case self::STATUS_REOPENED:
				$this->open      = true;
				$this->assigned  = true;
				$this->responded = true;
				$this->completed = false;
				$this->closed    = false;
				$this->status    = self::STATUS_REOPENED;
				break;
			
			case self::STATUS_CLOSED:
				$this->open      = true;
				$this->assigned  = true;
				$this->responded = true;
				$this->completed = true;
				if(empty($this->closed)) {
					$this->closedAt = new \DateTime();
				}
				$this->closed = true;
				$this->status = self::STATUS_CLOSED;
				break;
		}
	}
	
	public
	function initiateNumber() {
		if(empty($this->number)) {
			if(empty($this->numberMonthlyIncrement)) {
				return null;
			}
			$this->number = User::generateCharacterCode($this->numberMonthlyIncrement);
			$this->number .= '-' . $this->createdAt->format('-m-y');
		}
	}
	
	/**
	 * @return int|null
	 */
	public
	function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", mappedBy="parent", cascade={"persist","merge"})
	 */
	protected
		$children;
	
	public
	function addChild(
		WarrantyCase $c
	) {
		$this->children->add($c);
		$c->setParent($this);
	}
	
	public
	function removeChild(
		WarrantyCase $c
	) {
		$this->children->removeElement($c);
		$c->setParent(null);
	}
	
	/**
	 * @var WarrantyCase|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", cascade={"persist", "merge"}, inversedBy="children")
	 * @ORM\JoinColumn(name="id_parent_case", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$parent;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment", mappedBy="case", cascade={"persist","merge"},orphanRemoval=true)
	 * @ORM\OrderBy({"appointmentAt" = "ASC"})
	 */
	protected
		$appointments;
	
	public function hasAppointment(CaseAppointment $apmt = null) {
		if($apmt === null) {
			return false;
		}
		foreach($this->appointments as $a) {
			if($a === $apmt) {
				return true;
			}
		}
		
		return false;
	}
	
	public
	function addAppointment(
		CaseAppointment $appointment
	) {
		$this->appointments->add($appointment);
		$appointment->setCase($this);
	}
	
	public
	function removeAppointment(
		CaseAppointment $appointment
	) {
		$this->appointments->removeElement($appointment);
		$appointment->setCase(null);
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet", mappedBy="case", cascade={"persist","merge"},orphanRemoval=true)
	 */
	protected
		$serviceSheets;
	
	public
	function addServiceSheet(
		ServiceSheet $s
	) {
		$this->serviceSheets->add($s);
		$s->setCase($this);
	}
	
	public
	function removeServiceSheet(
		ServiceSheet $s
	) {
		$this->serviceSheets->removeElement($s);
		$s->setCase(null);
	}
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceNote", mappedBy="case", cascade={"persist","merge"},orphanRemoval=true)
	 * @ORM\OrderBy({"createdAt" = "DESC"})
	 */
	protected
		$serviceNotes;
	
	public
	function addServiceNote(
		ServiceNote $note
	) {
		$this->serviceNotes->add($note);
		$note->setCase($this);
	}
	
	public
	function removeServiceNote(
		ServiceNote $note
	) {
		$this->serviceNotes->removeElement($note);
		$note->setCase(null);
		if($this->hasAppointment($apmt = $note->getAppointment())) {
			$note->setAppointment(null);
			$apmt->setServiceNote(null);
		}
	}
	
	/**
	 * @var Warranty|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty", cascade={"persist", "merge"}, inversedBy="cases")
	 * @ORM\JoinColumn(name="id_warranty", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected
		$warranty;
	
	/**
	 * @var ServiceZone|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone", cascade={"persist", "merge"}, inversedBy="cases")
	 * @ORM\JoinColumn(name="id_service_zone", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected
		$serviceZone;
	
	/**
	 * @var OrganisationMember|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", cascade={"persist", "merge"}, inversedBy="createdCases")
	 * @ORM\JoinColumn(name="id_creator", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected
		$creator;
	
	/**
	 * @var OrganisationMember|null
	 * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", cascade={"persist", "merge"}, inversedBy="assignedCases")
	 * @ORM\JoinColumn(name="id_assignee", referencedColumnName="id", onDelete="SET NULL")
	 */
	protected
		$assignee;
	
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\AssigneeHistory", cascade={"persist", "merge"}, mappedBy="case")
	 */
	protected
		$assigneeHistory;
	
	public
	function addAssigneeHistory(
		AssigneeHistory $ah
	) {
		$this->assigneeHistory->add($ah);
		$ah->setCase($this);
	}
	
	public
	function removeAssigneeHistory(
		AssigneeHistory $ah
	) {
		$this->assigneeHistory->removeElement($ah);
		$ah->setCase(null);
	}
	
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected
		$createdAt;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime",nullable=true)
	 */
	protected
		$updatedAt;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected
		$appointmentAt;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="time", nullable=true)
	 */
	protected
		$appointmentFrom;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="time", nullable=true)
	 */
	protected
		$appointmentTo;
	
	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected
		$closedAt;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected
		$decisionRemarks;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$priority = self::PRIORITY_NORMAL;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$responded = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$completed = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$assigned = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":false})
	 */
	protected
		$closed = false;
	
	/**
	 * @var boolean
	 * @ORM\Column(type="boolean", options={"default":true})
	 */
	protected
		$open = true;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$status = self::STATUS_NEW;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$creatorName;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$number;
	
	/**
	 * @var int|null
	 * @ORM\Column(type="integer",nullable=true)
	 */
	protected
		$numberMonthlyIncrement;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$description;
	
	/**
	 * @var string|null
	 * @ORM\Column(type="string",nullable=true)
	 */
	protected
		$specialRemarks;
	
	/**
	 * @return Warranty|null
	 */
	public
	function getWarranty(): ?Warranty {
		return $this->warranty;
	}
	
	/**
	 * @param Warranty|null $warranty
	 */
	public
	function setWarranty(
		?Warranty $warranty
	): void {
		$this->warranty = $warranty;
	}
	
	/**
	 * @return \DateTime
	 */
	public
	function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt
	 */
	public
	function setCreatedAt(
		\DateTime $createdAt
	): void {
		$this->createdAt = $createdAt;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getNumber(): ?string {
		return $this->number;
	}
	
	/**
	 * @param null|string $number
	 */
	public
	function setNumber(
		?string $number
	): void {
		$this->number = $number;
	}
	
	/**
	 * @return ServiceZone|null
	 */
	public
	function getServiceZone(): ?ServiceZone {
		return $this->serviceZone;
	}
	
	/**
	 * @param ServiceZone|null $serviceZone
	 */
	public
	function setServiceZone(
		?ServiceZone $serviceZone
	): void {
		$this->serviceZone = $serviceZone;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public
	function getClosedAt(): ?\DateTime {
		return $this->closedAt;
	}
	
	/**
	 * @param \DateTime|null $closedAt
	 */
	public
	function setClosedAt(
		?\DateTime $closedAt
	): void {
		$this->closedAt = $closedAt;
	}
	
	/**
	 * @return OrganisationMember|null
	 */
	public
	function getAssignee(): ?OrganisationMember {
		return $this->assignee;
	}
	
	/**
	 * @param OrganisationMember|null $assignee
	 */
	public
	function setAssignee(
		?OrganisationMember $assignee
	): void {
		$this->assignee = $assignee;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getDescription(): ?string {
		return $this->description;
	}
	
	/**
	 * @param null|string $description
	 */
	public
	function setDescription(
		?string $description
	): void {
		$this->description = $description;
	}
	
	/**
	 * @return Collection
	 */
	public
	function getServiceNotes(): Collection {
		return $this->serviceNotes;
	}
	
	/**
	 * @param Collection $serviceNotes
	 */
	public
	function setServiceNotes(
		Collection $serviceNotes
	): void {
		$this->serviceNotes = $serviceNotes;
	}
	
	/**
	 * @return Collection
	 */
	public
	function getAssigneeHistory(): Collection {
		return $this->assigneeHistory;
	}
	
	/**
	 * @param Collection $assigneeHistory
	 */
	public
	function setAssigneeHistory(
		Collection $assigneeHistory
	): void {
		$this->assigneeHistory = $assigneeHistory;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public
	function getAppointmentAt(): ?\DateTime {
		return $this->appointmentAt;
	}
	
	/**
	 * @param \DateTime|null $appointmentAt
	 */
	public
	function setAppointmentAt(
		?\DateTime $appointmentAt
	): void {
		$this->appointmentAt = $appointmentAt;
	}
	
	/**
	 * @return OrganisationMember|null
	 */
	public
	function getCreator(): ?OrganisationMember {
		return $this->creator;
	}
	
	/**
	 * @param OrganisationMember|null $creator
	 */
	public
	function setCreator(
		?OrganisationMember $creator
	): void {
		$this->creator = $creator;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getCreatorName(): ?string {
		return $this->creatorName;
	}
	
	/**
	 * @param null|string $creatorName
	 */
	public
	function setCreatorName(
		?string $creatorName
	): void {
		$this->creatorName = $creatorName;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getPriority(): ?string {
		return $this->priority;
	}
	
	/**
	 * @param null|string $priority
	 */
	public
	function setPriority(
		?string $priority
	): void {
		$this->priority = $priority;
	}
	
	/**
	 * @return null|string
	 */
	public
	function getStatus(): ?string {
		return $this->status;
	}
	
	/**
	 * @param null|string $status
	 */
	public
	function setStatus(
		?string $status
	): void {
		$this->status = $status;
	}
	
	/**
	 * @return Collection
	 */
	public
	function getAppointments(): Collection {
		return $this->appointments;
	}
	
	/**
	 * @param Collection $appointments
	 */
	public
	function setAppointments(
		Collection $appointments
	): void {
		$this->appointments = $appointments;
	}
	
	/**
	 * @return bool
	 */
	public
	function isCompleted(): bool {
		return $this->completed;
	}
	
	/**
	 * @param bool $completed
	 */
	public
	function setCompleted(
		bool $completed
	): void {
		$this->completed = $completed;
	}
	
	/**
	 * @return bool
	 */
	public
	function isAssigned(): bool {
		return $this->assigned;
	}
	
	/**
	 * @param bool $assigned
	 */
	public
	function setAssigned(
		bool $assigned
	): void {
		$this->assigned = $assigned;
	}
	
	/**
	 * @return bool
	 */
	public
	function isClosed(): bool {
		return $this->closed;
	}
	
	/**
	 * @param bool $closed
	 */
	public
	function setClosed(
		bool $closed
	): void {
		$this->closed = $closed;
	}
	
	/**
	 * @return bool
	 */
	public
	function isOpen(): bool {
		return $this->open;
	}
	
	/**
	 * @param bool $open
	 */
	public
	function setOpen(
		bool $open
	): void {
		$this->open = $open;
	}
	
	/**
	 * @return bool
	 */
	public
	function isResponded(): bool {
		return $this->responded;
	}
	
	/**
	 * @param bool $responded
	 */
	public
	function setResponded(
		bool $responded
	): void {
		$this->responded = $responded;
	}
	
	/**
	 * @return Collection
	 */
	public
	function getChildren(): Collection {
		return $this->children;
	}
	
	/**
	 * @param Collection $children
	 */
	public
	function setChildren(
		Collection $children
	): void {
		$this->children = $children;
	}
	
	/**
	 * @return WarrantyCase|null
	 */
	public
	function getParent(): ?WarrantyCase {
		return $this->parent;
	}
	
	/**
	 * @param WarrantyCase|null $parent
	 */
	public
	function setParent(
		?WarrantyCase $parent
	): void {
		$this->parent = $parent;
	}
	
	/**
	 * @return Collection
	 */
	public
	function getServiceSheets(): Collection {
		return $this->serviceSheets;
	}
	
	/**
	 * @param Collection $serviceSheets
	 */
	public
	function setServiceSheets(
		Collection $serviceSheets
	): void {
		$this->serviceSheets = $serviceSheets;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public function getAppointmentTo(): ?\DateTime {
		return $this->appointmentTo;
	}
	
	/**
	 * @param \DateTime|null $appointmentTo
	 */
	public function setAppointmentTo(?\DateTime $appointmentTo): void {
		$this->appointmentTo = $appointmentTo;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public function getUpdatedAt(): ?\DateTime {
		return $this->updatedAt;
	}
	
	/**
	 * @param \DateTime|null $updatedAt
	 */
	public function setUpdatedAt(?\DateTime $updatedAt): void {
		$this->updatedAt = $updatedAt;
	}
	
	/**
	 * @return null|string
	 */
	public function getSpecialRemarks(): ?string {
		return $this->specialRemarks;
	}
	
	/**
	 * @param null|string $specialRemarks
	 */
	public function setSpecialRemarks(?string $specialRemarks): void {
		$this->specialRemarks = $specialRemarks;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public function getAppointmentFrom(): ?\DateTime {
		return $this->appointmentFrom;
	}
	
	/**
	 * @param \DateTime|null $appointmentFrom
	 */
	public function setAppointmentFrom(?\DateTime $appointmentFrom): void {
		$this->appointmentFrom = $appointmentFrom;
	}
	
	/**
	 * @return int|null
	 */
	public function getNumberMonthlyIncrement(): ?int {
		return $this->numberMonthlyIncrement;
	}
	
	/**
	 * @param int|null $numberMonthlyIncrement
	 */
	public function setNumberMonthlyIncrement(?int $numberMonthlyIncrement): void {
		$this->numberMonthlyIncrement = $numberMonthlyIncrement;
	}
}
