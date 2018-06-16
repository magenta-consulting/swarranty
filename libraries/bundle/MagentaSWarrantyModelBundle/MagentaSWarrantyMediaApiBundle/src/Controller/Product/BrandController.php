<?php

namespace Magenta\Bundle\SWarrantyApiBundle\Controller\Product;

use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BrandController extends Controller {
	public function categoriesAction(Brand $data): Collection {
		$cats = $data->getCategories();
		
		return $cats;
	}
	
	public function subCategoriesAction(Brand $data): Collection {
		$subCats = $data->getSubCategories();
		
		return $subCats;
	}
}