<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Doctrine\ORM\EntityRepository;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\ProductAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ManyToManyThingType;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserManager;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WarrantyAdmin extends BaseAdmin {
	
	protected $action;
	
	protected $datagridValues = array(
		// display the first page (default = 1)
//        '_page' => 1,
		// reverse order (default = 'ASC')
		'_sort_order' => 'DESC',
		// name of the ordered field (default = the model's id field, if any)
		'_sort_by'    => 'updatedAt',
	);
	
	protected function filterQueryByOrganisation(ProxyQuery $query, Organisation $organisation) {
		$pool      = $this->getConfigurationPool();
		$request   = $this->getRequest();
		$container = $pool->getContainer();
		/** @var Expr $expr */
		$expr          = $query->getQueryBuilder()->expr();
		$customerAlias = $query->entityJoin([ [ 'fieldName' => 'customer' ] ]);
		
		return $query->andWhere($expr->eq($customerAlias . '.organisation', $organisation->getId()));
	}
	
	public function getNewInstance() {
		/** @var Warranty $object */
		$object = parent::getNewInstance();
		if(empty($object->getCustomer())) {
			$object->setCustomer(new Customer());
		}
		
		return $object;
	}
	
	/**
	 * @param string   $name
	 * @param Warranty $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof Warranty
			? $object->getCustomer()->getName()
			: 'Warranty'; // shown in the breadcrumb on the create view
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
	
	public function getPersistentParameters() {
		$parameters = parent::getPersistentParameters();
		if( ! $this->hasRequest()) {
			return $parameters;
		}
		
		return array_merge($parameters, array(
			'organisation' => $this->getCurrentOrganisation()->getId()
		));
	}
	
	public function configureRoutes(RouteCollection $collection) {
		parent::configureRoutes($collection);
//		$collection->add('show_user_profile', $this->getRouterIdParameter() . '/show-user-profile');
		
	}
	
	public function getTemplate($name) {
		$_name = strtoupper($name);
		
		return parent::getTemplate($name);
	}
	
	protected function configureShowFields(ShowMapper $showMapper) {
		$showMapper
			->with('form_group.Warranty_details', [ 'class' => 'col-md-6' ])
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('email', null, [ 'label' => 'form.label_email' ])
			->add('homeAddress', null, [ 'label' => 'form.label_address' ])
			->add('homePostalCode', null, [ 'label' => 'form.label_postal_code' ])
			->end()
			->with('form_group.warranty_records', [ 'class' => 'col-md-6' ])
			->add('warranties', null, [
				'label'               => false,
				'associated_property' => 'id',
				'template'            => '@MagentaSWarrantyAdmin/Admin/Warranty/Warranty/CRUD/Association/show_one_to_many.html.twig'
			])
			->end();
		
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper->add('_action', 'actions', [
				'actions' => array(
					'show'   => array(),
					'edit'   => array(),
					'delete' => array(),
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
			->add('customer.name', null, [ 'editable' => true, 'label' => 'form.label_name' ])
			->add('customer.email', null, [ 'editable' => true, 'label' => 'form.label_email' ])
			->add('customer.telephone', null, [ 'editable' => true, 'label' => 'form.label_telephone' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$formMapper
			->with('form_group.customer_details', [ 'class' => 'col-md-6' ]);
		$formMapper
			->add('customer.name', null, [ 'label' => 'form.label_name' ])
			->add('customer.email', null, [ 'label' => 'form.label_email' ])
			->add('customer.telephone', null, [ 'label' => 'form.label_telephone' ]);
		$formMapper->end();
		$formMapper
			->with('form_group.warranty_details', [ 'class' => 'col-md-6' ]);
		$formMapper->add('product', ModelAutocompleteType::class, [
			'route'              => [
				'name'       => 'sonata_admin_retrieve_autocomplete_items',
				'parameters' => [ 'organisation' => $this->getCurrentOrganisation()->getId() ]
			],
			'property'           => 'searchText',
			'btn_add'            => false,
			'to_string_callback' => function(Product $entity) {
//				$entity->generateSearchText();
				
				return $entity->getSearchText();
			},
			'callback'           => function(ProductAdmin $admin, $property, $field) {

//				$queryBuilder, $alias, $field, $value
//				if( ! $value['value']) {
//					return;
//				}
//
//				/** @var Expr $expr */
//				$expr = $queryBuilder->expr();
//				$queryBuilder
//					->andWhere('organisation.id = :orgId')
////					->andWhere($expr->orX(
////
////					))
//					->setParameter('orgId', $this->getCurrentOrganisation()->getId());
//
				return true;
			},
		]);
		$formMapper->end();
	}
	
	/**
	 * @param Warranty $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param Warranty $object
	 */
	public function preUpdate($object) {
		parent::preUpdate($object);
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
			->add('customer.name')//			->add('locked')
		;
//			->add('groups')
//		;
	}
	
	
}