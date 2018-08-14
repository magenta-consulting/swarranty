<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\ProductAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ManyToManyThingType;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\MediaCollectionType;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ProductDetailType;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\WarrantyModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\ServiceZone;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WarrantyAdmin extends BaseAdmin {
	
	const CHILDREN = [
		WarrantyCaseAdmin::class => 'warranty',
	];
	
	protected $action;
	
	protected $datagridValues = array(
		// display the first page (default = 1)
//        '_page' => 1,
		// reverse order (default = 'ASC')
		'_sort_order' => 'DESC',
		// name of the ordered field (default = the model's id field, if any)
		'_sort_by'    => 'id',
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
		if(empty($object->getProduct())) {
			$object->setProduct(new Product());
		}
		
		return $object;
	}
	
	public function toString($object) {
		return $object instanceof Warranty
			? $object->getCustomer()->getName() . ' - ' . $object->getProduct()->getName()
			: 'Warranty'; // shown in the breadcrumb on the create view
	}
	
	protected function getAccess() {
		return array_merge(parent::getAccess(), [
			'create-case' => 'CREATE_CASE',
			'list-cases'  => 'LIST_CASES'
		]);
	}
	
	public function isGranted(
		$name, $object = null
	) {
		if(in_array($name, [ WarrantyModule::PERMISSION_CREATE_CASE, WarrantyModule::PERMISSION_LIST_CASES ])) {
			$org = $this->getCurrentOrganisation();
			$sys = $org->getSystem();
			$mod = $sys->getModuleByCode(WarrantyModule::MODULE_CODE);
			
			return $mod->isUserGranted($this->getCurrentOrganisationMember(), $name, $object, $this->getClass());
		}
		
		return parent::isGranted($name, $object);
	}
	
	public function createQuery($context = 'list') {
		$request = $this->getRequest();
		/** @var ProxyQueryInterface $query */
		$query = parent::createQuery($context);
		if(empty($this->getParentFieldDescription())) {
//            $this->filterQueryByPosition($query, 'position', '', '');
		}
		/** @var Expr $expr */
		$expr = $query->expr();
		/** @var QueryBuilder $qb */
		$qb            = $query->getQueryBuilder();
		$rootAlias     = $qb->getRootAliases()[0];
		$customerAlias = $query->entityJoin([ [ 'fieldName' => 'customer' ] ]);
		$statusFilter  = $this->getRequest()->query->get('statusFilter');
		switch($statusFilter) {
			case 'ALL':
				break;
			case 'NEW':
				$query->andWhere($expr->like($rootAlias . '.status', $expr->literal('NEW')));
				break;
			case 'APPROVED':
				$query->andWhere($expr->like($rootAlias . '.status', $expr->literal('APPROVED')));
				break;
			case 'NEAR-EXPIRY':
				$org   = $this->getCurrentOrganisation();
				$nep   = $org->getNearExpiryPeriod();
				$t     = new \DateTime();
				$today = \DateTime::createFromFormat('d M Y', $t->format('d M Y'));
				$today->setTime(0, 0, 0);
				$nepDt = clone $today;
				$nepDt->modify(sprintf('+%d days', $nep));
				$nepDt->setTime(23, 59, 59);
				$query->andWhere($expr->between($rootAlias . '.expiryDate', ':today', ':nep'))
				      ->setParameter('nep', $nepDt)
				      ->setParameter('today', $today);
				break;
			case 'EXPIRED':
				$query->andWhere($expr->lt($rootAlias . '.expiryDate', ':today'))
				      ->setParameter('today', new \DateTime());
				break;
			case 'REJECTED':
				$query->andWhere($expr->like($rootAlias . '.status', $expr->literal('REJECTED')));
				break;
		}
		
		if( ! empty($cid = $request->query->get('customer'))) {
			$query->andWhere($expr->eq($customerAlias . '.id', $cid));
		}
		
		if( ! empty($org = $this->getCurrentOrganisation(false))) {
//			$qb->join($customerAlias . '.organisation', 'organisation');
			$query->andWhere($expr->eq($customerAlias . '.organisation', $org->getId()));
		}
		$sql = $qb->getQuery()->getSQL();
		
		return $query;
	}
	
	public function getPersistentParameters() {
		$parameters = parent::getPersistentParameters();
		if( ! $this->hasRequest()) {
			return $parameters;
		}
		
		return array_merge($parameters, array(
			'organisation' => $this->getCurrentOrganisation(false)->getId()
		));
	}
	
	public function configureRoutes(RouteCollection $collection) {
		parent::configureRoutes($collection);
		$collection->add('detail', $this->getRouterIdParameter() . '/detail');
		$collection->add('transferOwnership', $this->getRouterIdParameter() . '/transfer-ownership/{customerId}');
	}
	
	protected function configureShowFields(ShowMapper $showMapper) {
		$showMapper
			->with('form_group.warranty_details', [ 'class' => 'col-md-6' ])
			->add('code', null, [ 'label' => 'form.label_reference_number' ])
			->add('product.brand', null, [
				'label'               => 'form.label_brand',
				'associated_property' => 'name'
			])
			->add('product.category', null, [
				'label'               => 'form.label_category',
				'associated_property' => 'name'
			])
			->add('product.subCategory', null, [
				'label'               => 'form.label_subcategory',
				'associated_property' => 'name'
			])
			->add('product.name', null, [ 'label' => 'form.label_model_name' ])
			->add('product.modelNumber', null, [ 'label' => 'form.label_model_number' ])
			->add('product.image', 'image', [ 'label' => 'form.label_model_image' ])
			->add('purchaseDate', null, [
				'label'  => 'form.label_purchase_date',
				'format' => 'd - m - Y'
			])
			->add('createdAt', null, [ 'label' => 'form.label_warranty_submission_date', 'format' => 'd - m - Y' ])
			->add('product.warrantyPeriod', null, [
				'editable' => true,
				'label'    => 'form.label_default_warranty_period'
			])
			->add('product.extendedWarrantyPeriod', null, [ 'label' => 'form.label_extended_warranty_period' ])
			->add('expiryDate', null, [ 'label' => 'form.label_warranty_expiry', 'format' => 'd - m - Y' ])
			->add('dealer.name', null, [ 'label' => 'form.label_dealer' ])
			->end();
		
		$showMapper
			->with('form_group.receipt_images', [ 'class' => 'col-md-6' ])
			->add('receiptImages', 'image', [ 'label' => 'form.label_reference_number' ])
			->end();
		
		$showMapper->with('form_group.customer_details', [ 'class' => 'col-md-6' ])
		           ->add('customer.name', null, [ 'label' => 'form.label_name' ])
		           ->add('customer.telephone', null, [ 'label' => 'form.label_telephone' ])
		           ->add('customer.email', null, [ 'label' => 'form.label_email' ])
		           ->add('customer.homeAddress', null, [ 'label' => 'form.label_address' ])
		           ->add('customer.homePostalCode', null, [ 'label' => 'form.label_postal_code' ])
		           ->end()
		           ->with('form_group.warranty_records', [ 'class' => 'col-md-6' ])
		           ->add('customer.warranties', 'warranty', [
			           'label'               => false,
			           'associated_property' => 'id'
//				'template'            => '@MagentaSWarrantyAdmin/CRUD/Association/show_one_to_many.html.twig'
		           ])
		           ->end();
		
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper->add('_action', 'actions', [
				'actions' => array(
					'review_submission'  => array( 'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/Action/list__action__review_submission.html.twig' ),
					'case'               => array( 'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/Action/list__action__case.html.twig' ),
					'case_add'           => array( 'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/Action/list__action__case_add.html.twig' ),
					'transfer_ownership' => array( 'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/Action/list__action__transfer_ownership.html.twig' ),
					
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
			->add('number', 'purchase_description', [
				'label'    => 'form.label_purchase_description',
				'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/CRUD/list_field.html.twig'
			])
			->add('customer.name', null, [ 'editable' => true, 'label' => 'form.label_name' ])
			->add('customer.email', null, [ 'editable' => true, 'label' => 'form.label_email' ])
			->add('customer.telephone', null, [ 'editable' => true, 'label' => 'form.label_telephone' ])
			->add('customer.homeAddress', null, [ 'editable' => true, 'label' => 'form.label_address' ])
//			->add('dealer.name', null, [ 'editable' => false, 'label' => 'form.label_dealer' ])
//			->add('product.brand.name', null, [ 'editable' => false, 'label' => 'form.label_brand' ])
//			->add('product.name', null, [ 'editable' => false, 'label' => 'form.label_model_name' ])
			->add('purchaseDate', 'date', [ 'editable' => false, 'label' => 'form.label_purchase_date' ])
			->add('createdAt', 'date', [ 'editable' => false, 'label' => 'form.label_submission_date' ])
			->add('expiryDate', 'date', [ 'editable' => false, 'label' => 'form.label_expiry_date' ]);
		
		$listMapper->add('receiptImages', 'image', [ 'editable' => true, 'label' => 'form.label_receipt_images' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$c = $this->getConfigurationPool()->getContainer();
		$formMapper
			->with('form_group.receipt_images', [ 'class' => 'col-md-6' ]);
		$formMapper
			->add('receiptImages', CollectionType::class,
				[
					// each entry in the array will be an "media" field
					'entry_type'    => MediaType::class,
					'allow_add'     => true,
					'allow_delete'  => true,
//					'source'        => $c->getParameter('MEDIA_API_BASE_URL') . $c->getParameter('MEDIA_API_PREFIX'),
					// these options are passed to each "media" type
					'entry_options' => array(
						'new_on_update' => false,
						'attr'          => array( 'class' => 'receipt-image' ),
						'context'       => 'receipt_image',
						'provider'      => 'sonata.media.provider.image'
					),
					
					'label' => false,
//					'class'         => Media::class
				]);
		
		$formMapper->add('description', CKEditorType::class, [
			'required' => false,
			'label'    => 'form.label_notes'
		]);
		
		$formMapper->end();
		$formMapper
			->with('form_group.customer_details', [ 'class' => 'col-md-3' ]);
		$formMapper
			->add('customer.name', null, [ 'label' => 'form.label_name' ])
			->add('customer.email', null, [ 'label' => 'form.label_email' ])
			->add('customer.dialingCode', NumberType::class, [ 'label' => 'form.label_dialing_code' ])
			->add('customer.telephone', null, [ 'required' => true, 'label' => 'form.label_telephone' ])
			->add('customer.homeAddress', null, [ 'required' => true, 'label' => 'form.label_address' ])
			->add('customer.homePostalCode', null, [ 'required' => true, 'label' => 'form.label_postal_code' ]);
		$formMapper->end();
		$formMapper
			->with('form_group.warranty_details', [ 'class' => 'col-md-3' ]);
		$formMapper->add('product', ModelType::class, [
//			'route'              => [
//				'name'       => 'sonata_admin_retrieve_autocomplete_items',
//				'parameters' => [ 'organisation' => $this->getCurrentOrganisation()->getId() ]
//			],
			'query'    => $this->getFilterByOrganisationQueryForModel(Product::class),
			'property' => 'searchText',
			'btn_add'  => false,
//			'to_string_callback' => function(Product $entity) {
////				$entity->generateSearchText();
//
//				return $entity->getSearchText();
//			},
//			'callback'           => function(ProductAdmin $admin, $property, $field) {
//
////				$queryBuilder, $alias, $field, $value
////				if( ! $value['value']) {
////					return;
////				}
////
////				/** @var Expr $expr */
////				$expr = $queryBuilder->expr();
////				$queryBuilder
////					->andWhere('organisation.id = :orgId')
//////					->andWhere($expr->orX(
//////
//////					))
////					->setParameter('orgId', $this->getCurrentOrganisation()->getId());
////
//				return true;
//			},
		]);
		$formMapper->add('product.image', ProductDetailType::class, [
			'required'       => false,
			'label'          => 'form.label_product_image',
			'appended_value' => 'months',
			'type'           => 'image',
			'class'          => Media::class
		]);
		$formMapper->add('product.warrantyPeriod', ProductDetailType::class, [
			'required'       => false,
			'label'          => 'form.label_default_warranty_period',
			'appended_value' => 'months',
			'type'           => 'warranty_period',
			'class'          => null
		]);
		$formMapper->add('product.extendedWarrantyPeriod', ProductDetailType::class, [
			'required'       => false,
			'label'          => 'form.label_extended_warranty_period',
			'appended_value' => 'month(s)',
			'type'           => 'extended_warranty_period',
			'class'          => null
		]);
		$formMapper->add('extendedWarrantyPeriodApproved', null, []);
		$formMapper->add('purchaseDate', DatePickerType::class, [
			'required'              => true,
			'format'                => 'dd-MM-yyyy',
			'placeholder'           => 'dd-mm-yyyy',
			'datepicker_use_button' => false,
			'label'                 => 'form.label_purchase_date',
		]);
		
		$formMapper->add('createdAt', DatePickerType::class, [
			'label'                 => 'form.label_warranty_submission_date',
			'datepicker_use_button' => false,
			'format'                => 'dd-MM-yyyy',
			'placeholder'           => 'dd-mm-yyyy'
		
		]);
		$formMapper->add('expiryDate', ProductDetailType::class, [
			'required'        => false,
//			'format'   => 'dd-MM-yyyy',
			'type'            => 'calculated_date',
			'source_property' => 'purchaseDate',
			'calculations'    => [
				[
					'operation' => 'add',
					'type'      => 'product',
					'value'     => 'warranty_period',
					'when'      => 'always'
				],
				[
					'operation' => 'add',
					'type'      => 'product',
					'value'     => 'extended_warranty_period',
					'when'      => [
						'type'  => 'form',
						'value' => 'extendedWarrantyPeriodApproved',
						'equal' => true
					]
				]
			]

//			'datepicker_use_button' => false,
//			'format'                => 'dd-MM-yyyy',
//			'placeholder'           => 'dd-mm-yyyy'
		
		]);
		
		$formMapper->add('dealer', ModelType::class, [
			'required' => false,
			'query'    => $this->getFilterByOrganisationQueryForModel(Dealer::class),
			'property' => 'name',
			'btn_add'  => false,
		]);
		
		
		$formMapper->end();
	}
	
	/**
	 * @param Warranty $object
	 */
	public function preValidate($object) {
		parent::preValidate($object);
		$ris = $object->getReceiptImages();
		$c   = $object->getCustomer();
		
		$cr        = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(Customer::class);
		$customers = $cr->findBy([
			'telephone'    => $c->getTelephone(),
			'dialingCode'  => $c->getDialingCode(),
			'organisation' => $c->getOrganisation()
		]);
		
		$cc = count($customers);
		if($cc > 0) {
			$object->setCustomer(null);
			$c->removeWarranties($object);
			$customers[0]->addWarranties($object);
			$object->setCustomer($customers[0]);
		}
		if($cc > 1) {
			/** @var Customer $_c */
			foreach($customers as $_c) {
				if($_c->getEmail() === $c->getEmail()) {
					$object->setCustomer(null);
					$customers[0]->removeWarranties($object);
					$_c->addWarranties($object);
					$object->setCustomer($_c);
					
				}
			}
		}
		
		/** @var Media $ri */
		foreach($ris as $m) {
			if( ! empty($m)) {
				$object->addReceiptImage($m);
			}
		}
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
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}