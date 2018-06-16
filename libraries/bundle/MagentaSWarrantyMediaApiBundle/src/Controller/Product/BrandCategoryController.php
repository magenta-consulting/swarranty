<?php

namespace Magenta\Bundle\SWarrantyMediaApiBundle\Controller\Product;

use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandCategoryController extends Controller {
	public function productsAction(BrandCategory $data): Collection {
		$prods = $data->getProducts();
		
		return $prods;
	}
}