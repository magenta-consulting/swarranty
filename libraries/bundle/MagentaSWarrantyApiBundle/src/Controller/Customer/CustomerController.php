<?php

namespace Magenta\Bundle\SWarrantyApiBundle\Controller\Customer;

use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller {
	
	public function updateAction($data): Customer {
		
		
		return $data;
	}
}