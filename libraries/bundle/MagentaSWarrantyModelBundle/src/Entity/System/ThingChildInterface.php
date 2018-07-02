<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;

interface ThingChildInterface extends OrganisationAwareInterface {
	
	public function getThing(): ?Thing;
}