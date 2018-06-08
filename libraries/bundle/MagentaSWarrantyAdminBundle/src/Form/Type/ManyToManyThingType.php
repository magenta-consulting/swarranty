<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManyToManyThingType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
//			->add('name')
			->addModelTransformer(new CallbackTransformer(
				function(Collection $collection = null) { // input - Collection to array
					if(empty($collection)) {
						return [];
					}
					
					// transform the array to a string
					return $collection->toArray();
				},
				function($array = null) { // output - array to Coll
					if(empty($array)) {
						return new ArrayCollection();
					}
					
					// transform the string back to an array
					return new ArrayCollection($array);
				}
			));;
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([
			// Configure your form options here
//			'data_class'   => null, // BrandCategory::class
			'router_id_param' => 'id',
			'label_property'   => 'name',
			'create_route'    => [ 'route_name' => '', 'route_params' => [] ],
			'update_route'    => [ 'route_name' => '', 'route_params' => [] ],
			'delete_route'    => [ 'route_name' => '', 'route_params' => [] ],
			'class'           => Thing::class,
			'choice_label'    => 'name',
			'multiple'        => true,
//			'compound' => true,
			'expanded'        => true,
//			'choices'    => [
//				$c1,
//				$c2,
//				$c3,
//				$c4,
//				$c5
//			]
		]);
	}
	
	public function buildView(FormView $view, FormInterface $form, array $options) {
		parent::buildView($view, $form, $options);
		
		$view->vars['label_property'] = $options['label_property'];
		$view->vars['router_id_param'] = $options['router_id_param'];
		$view->vars['create_route']    = $options['create_route'];
		$view->vars['update_route']    = $options['update_route'];
		$view->vars['delete_route']    = $options['delete_route'];
	}
	
	public function getParent() {
		return EntityType::class;
	}
	
	public function getBlockPrefix() {
		return 'many_to_many_thing';
	}
}
