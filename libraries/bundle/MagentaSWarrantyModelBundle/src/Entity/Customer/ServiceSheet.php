<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Customer;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="customer__service_sheet")
 */
class ServiceSheet
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
        $this->images = new ArrayCollection();
    }

    public function initiateNumber()
    {
        if (empty($this->number) && !empty($this->case) && !empty($apmt = $this->appointment) && !empty($assignee = $apmt->getAssignee())) {
            $now = new \DateTime();
            $this->number = User::generateCharacterCode();
            $this->number .= $this->case->getNumber().'-'.$now->format('dmy');
            $this->number .= '-'.$assignee->getId();
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
     * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media", mappedBy="imageServiceSheet", cascade={"persist","merge"},orphanRemoval=true)
     */
    protected $images;

    public function addImage(Media $image)
    {
        $this->images->add($image);
        $image->setImageServiceSheet($this);
    }

    public function removeImage(Media $image)
    {
        $this->images->removeElement($image);
        $image->setImageServiceSheet(null);
    }

    /**
     * @var CaseAppointment|null
     * @ORM\OneToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment", cascade={"persist", "merge"}, inversedBy="serviceSheet")
     * @ORM\JoinColumn(name="id_appointment", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $appointment;

    /**
     * @var WarrantyCase|null
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase", cascade={"persist", "merge"}, inversedBy="serviceSheets")
     * @ORM\JoinColumn(name="id_case", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $case;

    /**
     * @var string|null
     * @ORM\Column(type="string",nullable=true)
     */
    protected $number;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

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
     * @return Collection|null
     */
    public function getImages(): ?Collection
    {
        return $this->images;
    }

    /**
     * @param Collection|null $images
     */
    public function setImages(?Collection $images): void
    {
        $this->images = $images;
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
}
