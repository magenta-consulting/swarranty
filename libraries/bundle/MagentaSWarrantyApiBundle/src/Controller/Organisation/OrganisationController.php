<?php

namespace Magenta\Bundle\SWarrantyApiBundle\Controller\Organisation;

use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrganisationController extends Controller {
	public function brandsAction(Organisation $data): Collection {
		$brands = $data->getBrands();
		
		return $brands;
	}
	
	public function dealersAction(Organisation $data): Collection {
		$dealers = $data->getDealers();
		
		return $dealers;
	}
}