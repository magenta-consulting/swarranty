<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Organisation;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer\CustomerAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\BrandAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\BrandCategoryAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\BrandSubCategoryAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\BrandSubCategoryAdminController;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\ProductAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\ServiceZoneAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganisationAdmin extends BaseAdmin {
	
	const CHILDREN = [
		ACLAdmin::class              => 'organisation',
		ServiceZoneAdmin::class      => 'organisation',
		BrandAdmin::class            => 'organisation',
		BrandCategoryAdmin::class    => 'organisation',
		BrandSubCategoryAdmin::class => 'organisation',
		ProductAdmin::class          => 'organisation',
		CustomerAdmin::class         => 'organisation',
	];
	
	protected $action;
	
	protected $datagridValues = array(
		// display the first page (default = 1)
//        '_page' => 1,
		// reverse order (default = 'ASC')
		'_sort_order' => 'DESC',
		// name of the ordered field (default = the model's id field, if any)
		'_sort_by'    => 'updatedAt',
	);
	
	public function getNewInstance() {
		/** @var Organisation $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	/**
	 * @param string       $name
	 * @param Organisation $object
	 */
	public function isGranted($name, $object = null) {
		$container = $this->getConfigurationPool()->getContainer();
		$isAdmin   = $container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
//        $pos = $container->get(OrganisationService::class)->getPosition();
		if(in_array($name, [ 'CREATE', 'LIST' ])) {
			return $this->isAdmin();
		}
		if($name === 'EDIT') {
			if($isAdmin) {
				return true;
			}
			if( ! empty($object) && $object->getId() === $container->get(OrganisationService::class)->getOrganisation()->getId()) {
				return true;
			}
			
			return false;
		}
//        if (empty($isAdmin)) {
//            return false;
//        }
		
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof Organisation
			? $object->getName()
			: 'Organisation'; // shown in the breadcrumb on the create view
	}
	
	public function createQuery($context = 'list') {
		/** @var ProxyQueryInterface $query */
		$query = parent::createQuery($context);
		if(empty($this->getParentFieldDescription())) {
//            $this->filterQueryByPosition($query, 'position', '', '');
		}

//        $query->andWhere()
		
		return $query;
	}
	
	public function configureRoutes(RouteCollection $collection) {
		parent::configureRoutes($collection);
//		$collection->add('show_Organisation_profile', $this->getRouterIdParameter() . '/show-Organisation-profile');
		
	}
	
	public function getTemplate($name) {
		$_name = strtoupper($name);
		
		return parent::getTemplate($name);
	}
	
	protected function configureShowFields(ShowMapper $showMapper) {
	
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper->add('_action', 'actions', [
				'actions' => array(
					'children' => array( 'template' => '@MagentaSWarrantyAdmin/Admin/Organisation/Organisation/Action/list__action__children.html.twig' ),
					'edit'     => array(),
					'delete'   => array(),
//					'send_evoucher' => array( 'template' => '::admin/employer/employee/list__action_send_evoucher.html.twig' )

//                ,
//                    'view_description' => array('template' => '::admin/product/description.html.twig')
//                ,
//                    'view_tos' => array('template' => '::admin/product/tos.html.twig')
				),
				'label'   => 'form.label_action'
			]
		);
		
		$listMapper
			->add('name', null, [ 'editable' => true, 'label' => 'form.label_name' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/Organisation/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$formMapper->add('logo', MediaType::class, [
			'context'  => 'organisation_logo',
			'provider' => 'sonata.media.provider.image'
		])
		           ->end();
		$formMapper->add('name')
		           ->add('enabled')
		           ->add('nearExpiryPeriod', null, [ 'required' => true ])
		           ->add('adminUser', ModelAutocompleteType::class, array(
			           'required'           => false,
			           'property'           => 'email',
			           'to_string_callback' => function(User $entity) {
//				$entity->generateSearchText();
				
				           return $entity->getEmail();
			           }
		           ));
		$formMapper
			->add('fieldRequirements', ChoiceType::class, array(
				'multiple'           => true,
				'placeholder'        => 'Select required fields',
				'choices'            => [ 'form_field.label_registration_fields' => Organisation::FIELD_REGISTRATION ],
				'translation_domain' => $this->translationDomain
			));
		$formMapper->add('tos', CKEditorType::class);
		$formMapper->add('dataPolicy', CKEditorType::class);
//			->add('adminFamilyName')
//			->add('adminGivenName')
//			->add('adminPassword', TextType::class, [
//				'label'    => 'form.label_password',
//				'required' => ( ! $this->getSubject() || is_null($this->getSubject()->getId())),
//			])		;
		;
	}
	
	
	/**
	 * @param Organisation $object
	 */
	public function preValidate($object) {
		parent::preValidate($object);
		if( ! empty($logo = $object->getLogo())) {
			$logo->setLogoOrganisation($object);
		}
	}
	
	/**
	 * @param Organisation $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param Organisation $object
	 */
	public function preUpdate($object) {
		$c  = $this->getConfigurationPool()->getContainer();
		$mr = $c->get('doctrine')->getRepository(Media::class);
		if( ! empty($media = $mr->findOneBy([ 'logoOrganisation' => $object->getId() ]))) {
			if($media !== $object->getLogo()) {
				$em = $c->get('doctrine.orm.default_entity_manager');
				$em->remove($media);
				$em->flush($media);
			}
		}
		
	}
	
	///////////////////////////////////
	///
	///
	///
	///////////////////////////////////
	
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureDatagridFilters(DatagridMapper $filterMapper) {
		$filterMapper
			->add('id')
			->add('name')//			->add('locked')
		;
//			->add('groups')
//		;
	}
	
	/**
	 * @return null|Organisation
	 */
	public function getSubject() {
		return parent::getSubject();
	}
	
}