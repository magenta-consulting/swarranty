<?php

namespace Magenta\Bundle\SWarrantyApiBundle\Controller\Organisation;

use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrganisationMemberController extends Controller {
	
	public function nameAction(OrganisationMember $data): string {
		if(empty($person = $data->getPerson())) {
			return '';
		}
		
		return $person->getName();
		
	}
}