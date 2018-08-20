<?php
namespace Magenta\Bundle\SWarrantyModelBundle\Entity\Survey;
use Doctrine\ORM\Mapping as ORM;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;

class Survey
{
    protected $id;
    protected $ageGroup;
    protected $hearFrom;
    protected $reason;

}