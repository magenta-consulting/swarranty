<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Entity\System;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;

interface ThingChildInterface {
	
	public function getOrganisation(): Organisation;
	
}