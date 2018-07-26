<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Messaging;

use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\ProductAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ManyToManyThingType;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\MediaCollectionType;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ProductDetailType;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Messaging\MessageTemplate;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\CommunicationTemplateModule;
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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageTemplateAdmin extends BaseAdmin {
	
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
		$expr = $query->getQueryBuilder()->expr();
//		$customerAlias = $query->entityJoin([ [ 'fieldName' => 'customer' ] ]);

//		return $query->andWhere($expr->eq($customerAlias . '.organisation', $organisation->getId()));
		return parent::filterQueryByOrganisation($query, $organisation);
	}
	
	public function getNewInstance() {
		/** @var MessageTemplate $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	public function toString($object) {
		return $object instanceof MessageTemplate
			? $object->getName()
			: 'MessageTemplate'; // shown in the breadcrumb on the create view
	}
	
	protected function getAccess() {
		return array_merge(parent::getAccess(), [
		]);
	}
	
	public function isGranted(
		$name, $object = null
	) {
		if(in_array($name, [])) {
			$org = $this->getCurrentOrganisation();
			$sys = $org->getSystem();
			$mod = $sys->getModuleByCode(CommunicationTemplateModule::MODULE_CODE);
//			return $mod->isUserGranted($this->getCurrentOrganisationMember(), $name, $object, $this->getClass());
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
		$qb        = $query->getQueryBuilder();
		$rootAlias = $qb->getRootAliases()[0];
		
		if( ! empty($org = $this->getCurrentOrganisation(false))) {
//			$qb->join($customerAlias . '.organisation', 'organisation');
//			$query->andWhere($expr->eq($customerAlias . '.organisation', $org->getId()));
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
			->with('form_group.MessageTemplate_details', [ 'class' => 'col-md-6' ])
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('subject', null, [ 'label' => 'form.label_subject' ])
			->add('content', CKEditorType::class, [ 'label' => 'form.label_content' ])
			->end();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper->add('_action', 'actions', [
				'actions' => array(
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
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('subject', null, [ 'label' => 'form.label_subject' ])
			->add('enabled', null, [ 'label' => 'form.label_enabled', 'editable' => true ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$c = $this->getConfigurationPool()->getContainer();
		$formMapper->add('type', ChoiceType::class, array(
			'multiple'           => false,
			'placeholder'        => 'Select Template Type',
			'choices'            => [
				'form_field.label_registration_email_verification_template' => MessageTemplate::TYPE_REGISTRATION_VERIFICATION,
				'form_field.label_registration_copy_template'               => MessageTemplate::TYPE_REGISTRATION_COPY,
				'form_field.label_warranty_approved_notif_template'         => MessageTemplate::TYPE_WARRANTY_APPROVED,
				'form_field.label_technician_new_assignment_template'         => MessageTemplate::TYPE_TECHNICIAN_NEW_ASSIGNMENT,
				'form_field.label_warranty_new_registration_template'         => MessageTemplate::TYPE_WARRANTY_NEW_REGISTRATION,
			],
			'translation_domain' => $this->translationDomain
		));
		$formMapper->add('name', null, [ 'label' => 'form.label_name' ]);
		$formMapper->add('subject', null, [ 'label' => 'form.label_subject' ]);
		$formMapper->add('content', CKEditorType::class, [ 'label' => 'form.label_content' ]);
		
		$formMapper->end();
	}
	
	/**
	 * @param MessageTemplate $object
	 */
	public function preValidate($object) {
		parent::preValidate($object);
		
	}
	
	/**
	 * @param MessageTemplate $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param MessageTemplate $object
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
			->add('id')//			->add('customer.name')//			->add('locked')
		;
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}