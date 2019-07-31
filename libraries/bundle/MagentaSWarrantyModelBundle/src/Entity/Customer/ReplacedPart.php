<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__replaced_part")
 */
class ReplacedPart
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
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment", cascade={"persist", "merge"}, inversedBy="replacedParts")
     * @ORM\JoinColumn(name="id_appointment", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $appointment;

    /**
     * @var WarrantyCase|null
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", cascade={"persist", "merge"}, inversedBy="replacedParts")
     * @ORM\JoinColumn(name="id_case", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $case;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var float|null
     * @ORM\Column(type="float",options={"default":0}, precision=2)
     */
    protected $amount = 0;

    /**
     * @var int|null
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $quantity = 0;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $name;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $code;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $remarks;

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

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    /**
     * @param string|null $remarks
     */
    public function setRemarks(?string $remarks): void
    {
        $this->remarks = $remarks;
    }
}
