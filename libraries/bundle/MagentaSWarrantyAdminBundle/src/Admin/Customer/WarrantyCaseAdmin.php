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
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
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
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Valid;

class WarrantyCaseAdmin extends BaseAdmin {
	
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
		$warrantyAlias = $query->entityJoin([ [ 'fieldName' => 'warranty' ] ]);
		
		/** @var QueryBuilder $qb */
		$qb = $query->getQueryBuilder();
		$qb->join($warrantyAlias . '.customer', 'customer')
		   ->join('customer.organisation', 'organisation');
		
		
		return $query->andWhere($expr->eq('organisation.id', $organisation->getId()));
	}
	
	public function getNewInstance() {
		/** @var WarrantyCase $object */
		$object = parent::getNewInstance();
		if(empty($w = $object->getWarranty())) {
			$object->setWarranty($w = new Warranty());
		}
		if(empty($w->getCustomer())) {
			$w->setCustomer(new Customer());
		}
		if(empty($w->getProduct())) {
			$w->setProduct(new Product());
		}
		
		return $object;
	}
	
	/**
	 * @param string       $name
	 * @param WarrantyCase $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof WarrantyCase
			? $object->getWarranty()->getCustomer()->getName() . ' - ' . $object->getWarranty()->getProduct()->getName()
			: 'Warranty Case'; // shown in the breadcrumb on the create view
	}
	
	public function createQuery($context = 'list') {
		/** @var ProxyQueryInterface $query */
		$query = parent::createQuery($context);
		if(empty($this->getParentFieldDescription())) {
//            $this->filterQueryByPosition($query, 'position', '', '');
		}
		/** @var Expr $expr */
		$expr = $query->expr();
		/** @var QueryBuilder $qb */
		$qb           = $query->getQueryBuilder();
		$rootAlias    = $qb->getRootAliases()[0];
		$statusFilter = $this->getRequest()->query->get('statusFilter');
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
		
		//        $query->andWhere()
		
		
		return $query;
		
	}
	
	public function getPersistentParameters() {
		$parameters = parent::getPersistentParameters();
		if( ! $this->hasRequest()) {
			return $parameters;
		}
		
		if(empty($org = $this->getCurrentOrganisation(true))) {
			return $parameters;
		}
		
		return array_merge($parameters, array(
			'organisation' => $org->getId()
		));
	}
	
	public function configureRoutes(RouteCollection $collection) {
		parent::configureRoutes($collection);
//		$collection->add('show_user_profile', $this->getRouterIdParameter() . '/show-user-profile');
	
	}
	
	public function setTemplate($name, $template) {
		$_name = strtoupper($name);
		if($_name === 'BASE_LIST_FIELD') {
			$template = '@MagentaSWarrantyAdmin/Admin/Customer/WarrantyCase/CRUD/list_field.html.twig';
		}
		parent::setTemplate($name, $template);
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
			->add('purchaseDate', null, [ 'label' => 'form.label_purchase_date', 'format' => 'd - m - Y' ])
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
		           ->add('customer.warranties', null, [
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
//					'review_submission' => array( 'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/Action/list__action__review_submission.html.twig' ),
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
			->add('priority', 'choice', [
				'editable' => true,
				'label'    => 'form.label_priority',
				'choices'  => [
					WarrantyCase::PRIORITY_LOW    => WarrantyCase::PRIORITY_LOW,
					WarrantyCase::PRIORITY_NORMAL => WarrantyCase::PRIORITY_NORMAL,
					WarrantyCase::PRIORITY_HIGH   => WarrantyCase::PRIORITY_HIGH
				]
			])
			->add('warranty.product', 'product', [
				'label'               => 'form.label_product',
				'associated_property' => 'warranty.product.name'
			])
			->add('description', 'html', [
//				'editable' => true,
				'label' => 'form.label_case_detail'
			])
			->add('serviceNotes', null, [
				'label' => 'form.label_service_notes',
				'associated_property' => 'description'
				])
			->add('assigneeHistory', null, [
				'label'               => 'form.label_assignee_history',
				'associated_property' => 'assigneeName'
			])
			->add('serviceZone.name', null, [ 'label' => 'form.label_service_zone' ]);
		
		$listMapper
			->add('warranty.customer', 'customer', [ 'label' => 'form.label_customer' ])
			->add('status', null, [ 'label' => 'form.label_status' ])
			->add('appointmentAt', null, [
				'label'  => 'form.label_appointment_at',
				'format' => 'd-m-Y'
			]);

//		$listMapper->add('warranty.receiptImages', 'image', [
//			'editable' => true,
//			'label'    => 'form.label_receipt_images'
//		])
		;

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
//		$link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', array());
		$c = $this->getConfigurationPool()->getContainer();
//		$formMapper
//			->with('form_group.receipt_images', [ 'class' => 'col-md-6' ]);
//		$formMapper
//			->add('receiptImages', CollectionType::class,
//				[
//					// each entry in the array will be an "media" field
//					'entry_type'    => MediaType::class,
//					'allow_add'     => true,
//					'allow_delete'  => true,
////					'source'        => $c->getParameter('MEDIA_API_BASE_URL') . $c->getParameter('MEDIA_API_PREFIX'),
//					// these options are passed to each "media" type
//					'entry_options' => array(
//						'new_on_update' => false,
//						'attr'          => array( 'class' => 'receipt-image' ),
//						'context'       => 'receipt_image',
//						'provider'      => 'sonata.media.provider.image'
//					),
//
//					'label' => false,
////					'class'         => Media::class
//				]);
//		$formMapper->end();
//		$formMapper
//			->with('form_group.customer_details', [ 'class' => 'col-md-3' ]);
//		$formMapper
//			->add('warranty', , [ 'label' => 'form.label_warranty' ])
//		;
//		$formMapper->end();
		$formMapper
			->with('form_group.case_details', [ 'class' => 'col-md-6' ]);
		$formMapper->add('warranty', ModelAutocompleteType::class, [
			'route'              => [
				'name'       => 'sonata_admin_retrieve_autocomplete_items',
				'parameters' => [ 'organisation' => $this->getCurrentOrganisation()->getId() ]
			],
//			'query'    => $this->getFilterByOrganisationQueryForModel(Product::class),
			'property'           => 'fullText',
//			'btn_add'  => false,
			'to_string_callback' => function(Warranty $entity) {
//				$entity->generateSearchText();
				
				return $entity->getSearchText();
			},
			'callback'           => function(WarrantyAdmin $admin, $property, $field) {
				
				return true;
			},
		])
		           ->add('description', CKEditorType::class, [
			           'required' => false,
			           'label'    => 'form.label_case_detail'
		           ]);
		$formMapper->end();
		$formMapper
			->with('form_group.case_assignment', [ 'class' => 'col-md-6' ]);
		$formMapper->add('serviceZone', ModelType::class, [ 'property' => 'name' ]);
		if(empty($this->subject->getAssignee())) {
			$formMapper
				->add('assignee', ModelType::class, [
					'label'    => 'form.label_assign_technician',
					'property' => 'person.name'
				])
				->add('appointmentAt', DateTimePickerType::class, [
					'required'              => false,
					'format'                => 'dd-MM-yyyy, H:m',
					'placeholder'           => 'dd-mm-yyyy, hour:minutes',
					'datepicker_use_button' => false,
				]);
		} else {
			$formMapper->add('appointments', CollectionType::class,
				array(
					'required'    => true,
					'constraints' => new Valid(),
					'label'       => 'form.label_appointments',
//					'btn_catalogue' => 'InterviewQuestionSetAdmin'
				), array(
					'edit'            => 'inline',
					'inline'          => 'table',
					//						'sortable' => 'position',
					'link_parameters' => $this->getPersistentParameters(),
					'admin_code'      => CaseAppointmentAdmin::class,
					'delete'          => null,
				)
			);
		}
		
		
		$formMapper->end();
	}
	
	/**
	 * @param WarrantyCase $object
	 */
	public function preValidate($object) {
		parent::preValidate($object);
//		$ris = $object->getReceiptImages();
//		/** @var Media $ri */
//		foreach($ris as $m) {
//			$object->addReceiptImage($m);
//		}
	}
	
	/**
	 * @param WarrantyCase $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
//		if( ! $object->isEnabled()) {
//			$object->setEnabled(true);
//		}
	}
	
	/**
	 * @param WarrantyCase $object
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
			->add('warranty.customer.name')//			->add('locked')
		;
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}