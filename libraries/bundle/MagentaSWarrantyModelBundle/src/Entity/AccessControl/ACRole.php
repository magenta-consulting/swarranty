<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @ORM\Entity()
 * @ORM\Table(name="access__role")
 */
class ACRole extends Thing
{
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
    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getEntryStatus($permission, $moduleCode)
    {
        $module = $this->organisation->getSystem()->getModuleByCode($moduleCode);
        if (empty($module)) {
            throw new NotFoundHttpException(sprintf('MODULE %s not found', $moduleCode));
        }

        $permission = strtoupper($permission);
        if (empty($entry = $this->getEntry($permission, $module))) {
            return ACEntry::STATUS_EMPTY;
        } elseif ($entry->isEnabled()) {
            return ACEntry::STATUS_GRANTED;
        } else {
            return ACEntry::STATUS_DENIED;
        }
    }

    public function grantPermission($permission, $moduleCode)
    {
        $module = $this->organisation->getSystem()->getModuleByCode($moduleCode);
        if (empty($module)) {
            throw new NotFoundHttpException(sprintf('MODULE %s not found', $moduleCode));
        }

        $permission = strtoupper($permission);
        if (empty($entry = $this->getEntry($permission, $module))) {
            $entry = new ACEntry();
            $entry->setModule($module);
            $entry->setRole($this);
            $entry->setPermission($permission);
            $this->addEntry($entry);
        }
        $entry->setEnabled(true);

        return $entry;
    }

    public function denyPermission($permission, $moduleCode)
    {
    }

    public function getEntryByModuleCode($permission, $moduleCode)
    {
        $module = $this->organisation->getSystem()->getModuleByCode($moduleCode);
        if (empty($module)) {
            throw new NotFoundHttpException(sprintf('MODULE %s not found', $moduleCode));
        }
        $permission = strtoupper($permission);

        return $this->getEntry($permission, $module);
    }

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember", mappedBy="role", cascade={"persist","merge"})
     */
    protected $members;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACEntry", mappedBy="role", cascade={"persist","merge"}, orphanRemoval=true)
     */
    protected $entries;

    public function getEntry($permission, SystemModule $module)
    {
        /** @var ACEntry $entry */
        foreach ($this->entries as $entry) {
            if ($entry->getModule() === $module && $entry->getPermission() === $permission) {
                return $entry;
            }
        }

        return null;
    }

    public function addEntry(ACEntry $entry)
    {
        $this->entries->add($entry);
        $entry->setRole($this);
    }

    public function removeEntry(ACEntry $entry)
    {
        $this->entries->removeElement($entry);
        $entry->setRole(null);
    }

    /**
     * @var Organisation
     * @ORM\ManyToOne(targetEntity="Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation", inversedBy="roles", cascade={"persist","merge"})
     * @ORM\JoinColumn(name="id_organisation", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $organisation;

    /**
     * @return Collection
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    /**
     * @param Collection $entries
     */
    public function setEntries(Collection $entries): void
    {
        $this->entries = $entries;
    }
}
