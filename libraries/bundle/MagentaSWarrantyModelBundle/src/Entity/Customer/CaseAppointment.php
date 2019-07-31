<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearch;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__case_appointment")
 */
class CaseAppointment extends FullTextSearch
{
    const STATUS_NEW = 'NEW';
    const STATUS_VIEWED = 'VIEWED';
    const STATUS_VISITED = 'VISITED';
    const STATUS_CANCELLED = 'CANCELLED';

    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->replacedParts = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->initiateServiceSheet();
    }

    /**
     * @param OrganisationMember|null $creator
     */
    public function setCreator(?OrganisationMember $creator): void
    {
        $this->creator = $creator;
        if (!empty($creator)) {
            if (!empty($p = $creator->getPerson())) {
                $this->creatorName = $p->getName();
            }
        }
    }

    public function getAssigneeName()
    {
        if (!empty($assignee = $this->assignee)) {
            $p = $assignee->getPerson();
            if (!empty($p)) {
                return $p->getName();
            }
        }

        return '';
    }

    public function initiateServiceSheet()
    {
        if (empty($this->serviceSheet)) {
            $this->createServiceSheet();
        }

        return $this->serviceSheet;
    }

    public function createServiceSheet()
    {
        $ss = new ServiceSheet();
        $ss->setAppointment($this);
        $ss->setCase($this->case);
        if (!empty($this->case)) {
            $this->case->addServiceSheet($ss);
        }
        $this->serviceSheet = $ss;

        return $this->serviceSheet;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->case->getWarranty()->getOrganisation();
    }

    public function generateFullText()
    {
        if (!empty($this->assignee)) {
            $name = $this->assignee->getPerson()->getName();
        } else {
            $name = '';
        }

        if (empty($this->appointmentAt)) {
            $at = '';
        } else {
            $at = $this->appointmentAt->format('d-m-Y');
        }

        $this->fullText = $name.' - '.$at;
    }

    public function generateSearchText()
    {
        $this->searchText = $this->assignee->getPerson()->getName().' - '.((empty($this->appointmentAt)) ? '' : $this->appointmentAt->format('d-m-Y'));
    }

    public function initiateNumber()
    {
        if (empty($this->number)) {
            $now = new \DateTime();
            $this->number = User::generateCharacterCode();
            if (!empty($this->purchaseDate)) {
                $this->number .= '-'.$this->purchaseDate->format('my');
            } else {
                $this->number .= '-'.'XXXX';
            }
            $this->number .= '-'.$now->format('my');
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var Collection|null
     * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ReplacedPart", mappedBy="appointment", cascade={"persist","merge"})
     */
    protected $replacedParts;

    /**
     * @var ServiceSheet|null
     * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet", mappedBy="appointment", cascade={"persist","merge"})
     */
    protected $serviceSheet;

    /**
     * @var ServiceNote|null
     * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceNote", mappedBy="appointment", cascade={"persist","merge"})
     */
    protected $serviceNote;

    /**
     * @var WarrantyCase|null
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", cascade={"persist", "merge"}, inversedBy="appointments")
     * @ORM\JoinColumn(name="id_case", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $case;

    /**
     * @var OrganisationMember|null
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", cascade={"persist", "merge"}, inversedBy="createdCaseAppointments")
     * @ORM\JoinColumn(name="id_creator", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $creator;

    /**
     * @var OrganisationMember|null
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", cascade={"persist", "merge"}, inversedBy="appointments")
     * @ORM\JoinColumn(name="id_assignee", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $assignee;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $appointmentAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", nullable=true)
     */
    protected $appointmentFrom;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="time", nullable=true)
     */
    protected $appointmentTo;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $visitedAt;

    /**
     * @var float|null
     * @ORM\Column(type="float",options={"default":0}, precision=2)
     */
    protected $serviceCost = 0;

    /**
     * @var float|null
     * @ORM\Column(type="float",options={"default":0}, precision=2)
     */
    protected $transportAndInspectionCost = 0;

    /**
     * @var float|null
     * @ORM\Column(type="float",options={"default":0}, precision=2)
     */
    protected $partsCost = 0;

    /**
     * @var float|null
     * @ORM\Column(type="float",options={"default":0}, precision=2)
     */
    protected $amountCollected = 0;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $partsReplaced;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $productIssue;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $status = self::STATUS_NEW;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $creatorName;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $number;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return null|string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param null|string $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return OrganisationMember|null
     */
    public function getAssignee(): ?OrganisationMember
    {
        return $this->assignee;
    }

    /**
     * @param OrganisationMember|null $assignee
     */
    public function setAssignee(?OrganisationMember $assignee): void
    {
        $this->assignee = $assignee;
    }

    /**
     * @return \DateTime|null
     */
    public function getAppointmentAt(): ?\DateTime
    {
        return $this->appointmentAt;
    }

    /**
     * @param \DateTime|null $appointmentAt
     */
    public function setAppointmentAt(?\DateTime $appointmentAt): void
    {
        $this->appointmentAt = $appointmentAt;
    }

    /**
     * @return OrganisationMember|null
     */
    public function getCreator(): ?OrganisationMember
    {
        return $this->creator;
    }

    /**
     * @return null|string
     */
    public function getCreatorName(): ?string
    {
        return $this->creatorName;
    }

    /**
     * @param null|string $creatorName
     */
    public function setCreatorName(?string $creatorName): void
    {
        $this->creatorName = $creatorName;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|string $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ServiceNote|null
     */
    public function getServiceNote(): ?ServiceNote
    {
        return $this->serviceNote;
    }

    /**
     * @param ServiceNote|null $serviceNote
     */
    public function setServiceNote(?ServiceNote $serviceNote): void
    {
        $this->serviceNote = $serviceNote;
    }

    /**
     * @return WarrantyCase|null
     */
    public function getCase(): ?WarrantyCase
    {
        return $this->case;
    }

    /**
     * @param WarrantyCase|null $case
     */
    public function setCase(?WarrantyCase $case): void
    {
        $this->case = $case;
    }

    /**
     * @return \DateTime|null
     */
    public function getVisitedAt(): ?\DateTime
    {
        return $this->visitedAt;
    }

    /**
     * @param \DateTime|null $visitedAt
     */
    public function setVisitedAt(?\DateTime $visitedAt): void
    {
        $this->visitedAt = $visitedAt;
    }

    /**
     * @return ServiceSheet|null
     */
    public function getServiceSheet(): ?ServiceSheet
    {
        return $this->serviceSheet;
    }

    /**
     * @param ServiceSheet|null $serviceSheet
     */
    public function setServiceSheet(?ServiceSheet $serviceSheet): void
    {
        $this->serviceSheet = $serviceSheet;
    }

    /**
     * @return \DateTime|null
     */
    public function getAppointmentTo(): ?\DateTime
    {
        return $this->appointmentTo;
    }

    /**
     * @param \DateTime|null $appointmentTo
     */
    public function setAppointmentTo(?\DateTime $appointmentTo): void
    {
        $this->appointmentTo = $appointmentTo;
    }

    /**
     * @return \DateTime|null
     */
    public function getAppointmentFrom(): ?\DateTime
    {
        return $this->appointmentFrom;
    }

    /**
     * @param \DateTime|null $appointmentFrom
     */
    public function setAppointmentFrom(?\DateTime $appointmentFrom): void
    {
        $this->appointmentFrom = $appointmentFrom;
    }

    /**
     * @return float|null
     */
    public function getAmountCollected(): ?float
    {
        return $this->amountCollected;
    }

    /**
     * @param float|null $amountCollected
     */
    public function setAmountCollected(?float $amountCollected): void
    {
        $this->amountCollected = $amountCollected;
    }

    /**
     * @return null|string
     */
    public function getPartsReplaced(): ?string
    {
        return $this->partsReplaced;
    }

    /**
     * @param null|string $partsReplaced
     */
    public function setPartsReplaced(?string $partsReplaced): void
    {
        $this->partsReplaced = $partsReplaced;
    }

    /**
     * @return null|string
     */
    public function getProductIssue(): ?string
    {
        return $this->productIssue;
    }

    /**
     * @param null|string $productIssue
     */
    public function setProductIssue(?string $productIssue): void
    {
        $this->productIssue = $productIssue;
    }

    /**
     * @return Collection|null
     */
    public function getReplacedParts(): ?Collection
    {
        return $this->replacedParts;
    }

    /**
     * @param Collection|null $replacedParts
     */
    public function setReplacedParts(?Collection $replacedParts): void
    {
        $this->replacedParts = $replacedParts;
    }

    /**
     * @return float|null
     */
    public function getServiceCost(): ?float
    {
        return $this->serviceCost;
    }

    /**
     * @param float|null $serviceCost
     */
    public function setServiceCost(?float $serviceCost): void
    {
        $this->serviceCost = $serviceCost;
    }

    /**
     * @return float|null
     */
    public function getTransportAndInspectionCost(): ?float
    {
        return $this->transportAndInspectionCost;
    }

    /**
     * @param float|null $transportAndInspectionCost
     */
    public function setTransportAndInspectionCost(?float $transportAndInspectionCost): void
    {
        $this->transportAndInspectionCost = $transportAndInspectionCost;
    }

    /**
     * @return float|null
     */
    public function getPartsCost(): ?float
    {
        return $this->partsCost;
    }

    /**
     * @param float|null $partsCost
     */
    public function setPartsCost(?float $partsCost): void
    {
        $this->partsCost = $partsCost;
    }
}
