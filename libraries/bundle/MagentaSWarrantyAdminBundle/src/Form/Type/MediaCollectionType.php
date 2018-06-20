<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaCollectionType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
//			->add('name')
			->addModelTransformer(new CallbackTransformer(
				function(Collection $collection = null) { // input - Collection to array
					if(empty($collection)) {
						return [];
					}
					
					// transform the Collection to an array
					return $collection->toArray();
				},
				function($array = null) { // output - array to Collection
					if(empty($array)) {
						return new ArrayCollection();
					}
					
					// transform the array  back to a Collection
					return new ArrayCollection($array);
				}
			));;
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([
			// Configure your form options here
//			'data_class'   => null, // BrandCategory::class
			'router_id_param' => 'id',
			'source'          => 'http://127.0.0.1:8000/index.php/media-api/media/14/binaries/admin/view.json',
			'create_route'    => [ 'route_name' => '', 'route_params' => [] ],
			'update_route'    => [ 'route_name' => '', 'route_params' => [] ],
			'delete_route'    => [ 'route_name' => '', 'route_params' => [] ],
			'new_on_update'   => false,
			'context'         => null,
			'provider'        => 'sonata.media.provider.image',
			'class'           => MediaInterface::class,
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
		
		$view->vars['source']          = $options['source'];
		$view->vars['router_id_param'] = $options['router_id_param'];
		$view->vars['create_route']    = $options['create_route'];
		$view->vars['update_route']    = $options['update_route'];
		$view->vars['delete_route']    = $options['delete_route'];
		$view->vars['new_on_update']   = $options['new_on_update'];
		$view->vars['context']         = $options['context'];
		$view->vars['provider']        = $options['provider'];
	}
	
	public function getParent() {
		return EntityType::class;
	}
	
	public function getBlockPrefix() {
		return 'media_collection';
	}
}
