<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandCategoriesType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
//			->add('name')
			->addModelTransformer(new CallbackTransformer(
				function(Collection $collection = null) { // input - Collection
					if(empty($collection)){
						return [];
					}
					// transform the array to a string
					return $collection->toArray();
				},
				function($array = null) { // output - array needed
					if(empty($array)){
						return new ArrayCollection();
					}
					// transform the string back to an array
					return new ArrayCollection($array);
				}
			));;
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$c1 = new BrandCategory();
		$c1->setName('hello c1');
		
		$c2 = new BrandCategory();
		$c2->setName('hello c2');
		
		$c3 = new BrandCategory();
		$c3->setName('hello c3');
		
		$c4 = new BrandCategory();
		$c4->setName('hello c4');
		
		$c5 = new BrandCategory();
		$c5->setName('hello c5');
		
		$resolver->setDefaults([
			// Configure your form options here
			'data_class'   => null, // BrandCategory::class
			'class'        => BrandCategory::class,
			'choice_label' => 'name',
			'multiple'     => true,
//			'compound' => true,
			'expanded'     => true,
//			'choices'    => [
//				$c1,
//				$c2,
//				$c3,
//				$c4,
//				$c5
//			]
		]);
	}
	
	public function getParent() {
		return EntityType::class;
	}
	
	public function getBlockPrefix() {
		return 'brand_categories';
	}
}
