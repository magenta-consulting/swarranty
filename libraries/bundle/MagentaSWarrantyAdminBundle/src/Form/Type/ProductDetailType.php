<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Sonata\CoreBundle\Date\MomentFormatConverter;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class ProductDetailType extends AbstractType {
	/** @var RegistryInterface */
	private $registry;
	/**
	 * @var TranslatorInterface
	 */
	protected $translator;
	
	/**
	 * @var string
	 */
	protected $locale;
	/** @var DatePickerType */
	protected $dpt;
	/**
	 * @var MomentFormatConverter
	 */
	private $formatConverter;
	
	public function __construct(RegistryInterface $r, MomentFormatConverter $formatConverter, TranslatorInterface $translator = null) {
		$this->registry        = $r;
		$this->formatConverter = $formatConverter;
		$this->translator      = $translator;
		$this->dpt             = new DatePickerType($formatConverter, $translator);
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->addModelTransformer(new CallbackTransformer(
			function($data = null) use ($options) { // input - Collection to array
				if(empty($data)) {
					return $data;
				}
				
				// transform the array to a string
				if( ! empty($options['class'])) {
					return $data->getId();
				} elseif($data instanceof \DateTime) {
					return $data->format('d-m-Y');
				}
				
				return $data;
			},
			function($model = null) use ($options) { // output - array to Coll
				if(empty($model)) {
					return $model;
				}
				$data = $model;
				// transform the string back to an array
				if( ! empty($options['class'])) {
					$data = $this->registry->getRepository($options['class'])->find($model);
				} elseif($options['type'] === 'calculated_date') {
					return \DateTime::createFromFormat('d-m-Y', $data);
				}
				
				return $data;
			}
		));;;
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([
			// Configure your form options here
//			'data_class'   => null, // BrandCategory::class
			'detail_route'       => 'admin_magenta_swarrantymodel_product_product_detail',
			'translation_domain' => 'MagentaSWarrantyAdmin',
//			'label'              => false,
			'type'               => null,
			'class'              => null,
			'appended_value'     => '', // for {wPeriod} months
			
			/////////////// type calculated_date /////////////
			'source_property'    => '',
			'target_property'    => '',
			'calculations'       => [],
			///////////// end type calculated_date \\\\\\\\\\\
			'router_id_param'    => 'id',
			'create_route'       => [ 'route_name' => '', 'route_params' => [] ],
			'update_route'       => [ 'route_name' => '', 'route_params' => [] ],
			'delete_route'       => [ 'route_name' => '', 'route_params' => [] ],
			'new_on_update'      => false,
			'context'            => null,
			'choice_label'       => 'name',
			'product_property'   => 'product',
			'multiple'           => true,
//			'compound' => true,
			'expanded'           => true,
//			'choices'    => [
//				$c1,
//				$c2,
//				$c3,
//				$c4,
//				$c5
//			]
			'provider'           => 'sonata.media.provider.image',
		]);
//		$this->dpt->configureOptions($resolver);
	}
	
	public function buildView(FormView $view, FormInterface $form, array $options) {
		parent::buildView($view, $form, $options);
		$view->vars['detail_route']     = $options['detail_route'];
		$view->vars['product_property'] = $options['product_property'];
		$view->vars['type']             = $options['type'];
		$view->vars['appended_value']   = $options['appended_value'];
		
		///// calculated_date ///////////
		$view->vars['source_property'] = $options['source_property'];
		$view->vars['target_property'] = $options['target_property'];
		$view->vars['calculations']    = $options['calculations'];
		
		////////// DatePicker ////////
		$view->vars['datepicker_use_button'] = false;// $options['datepicker_use_button'];
		$view->vars['moment_format']         = 'DD-MM-YYYY'; //$options['moment_format'];
		$view->vars['widget']                = 'single_text';
		$view->vars['dp_options']            = [];
		
		////////////////////////////////////////////////////////////
		$view->vars['router_id_param'] = $options['router_id_param'];
		$view->vars['create_route']    = $options['create_route'];
		$view->vars['update_route']    = $options['update_route'];
		$view->vars['delete_route']    = $options['delete_route'];
		$view->vars['new_on_update']   = $options['new_on_update'];
		$view->vars['context']         = $options['context'];
		$view->vars['provider']        = $options['provider'];
	}
	
	public function finishView(FormView $view, FormInterface $form, array $options) {
		parent::finishView($view, $form, $options);
//		$this->dpt->finishView($view, $form, $options);
	}
	
	public function getParent() {
		return HiddenType::class;
	}
	
	public function getBlockPrefix() {
		return 'product_detail';
	}
}
