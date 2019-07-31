<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__service_note")
 */
class ServiceNote
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer",options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var CaseAppointment|null
     * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment", cascade={"persist", "merge"}, inversedBy="serviceNote")
     * @ORM\JoinColumn(name="id_appointment", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $appointment;

    /**
     * @var WarrantyCase|null
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", cascade={"persist", "merge"}, inversedBy="serviceNotes")
     * @ORM\JoinColumn(name="id_case", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $case;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $description;

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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return CaseAppointment|null
     */
    public function getAppointment(): ?CaseAppointment
    {
        return $this->appointment;
    }

    /**
     * @param CaseAppointment|null $appointment
     */
    public function setAppointment(?CaseAppointment $appointment): void
    {
        $this->appointment = $appointment;
    }
}
