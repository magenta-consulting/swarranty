<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Doctrine\ORM\EntityRepository;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ManyToManyThingType;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
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

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerAdmin extends BaseAdmin {
	
	const CHILDREN = [
		WarrantyAdmin::class => 'customer',
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
		/** @var Customer $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	/**
	 * @param string   $name
	 * @param Customer $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof Customer
			? $object->getName()
			: 'Customer'; // shown in the breadcrumb on the create view
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
		
		$request = $this->getRequest();
		
		if($request->get('workflow') === 'transfer-ownership') {
			if( ! empty($wid = $request->get('warranty'))) {
				$parameters = array_merge($parameters, [
					'workflow' => 'transfer-ownership',
					'warranty' => $wid
				]);
			}
		}
		
		if(empty($org = $this->getCurrentOrganisation(false))) {
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
	
	public function getTemplate($name) {
		$_name = strtoupper($name);
		
		return parent::getTemplate($name);
	}
	
	protected function configureShowFields(ShowMapper $showMapper) {
		$showMapper
			->with('form_group.customer_details', [ 'class' => 'col-md-6' ])
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('email', null, [ 'label' => 'form.label_email' ])
			->add('homeAddress', null, [ 'label' => 'form.label_address' ])
			->add('homePostalCode', null, [ 'label' => 'form.label_postal_code' ])
			->end()
			->with('form_group.warranty_records', [ 'class' => 'col-md-6' ])
			->add('warranties', null, [
				'label'               => false,
				'associated_property' => 'product.name'
//				'template'            => '@MagentaSWarrantyAdmin/CRUD/Association/show_one_to_many.html.twig'
			])
			->end();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$actions = [];
		$request = $this->getRequest();
		if($request->get('workflow') === 'transfer-ownership') {
			$actions = [ 'transfer_warranty_ownership' => [ 'template' => '@MagentaSWarrantyAdmin/Admin/Customer/Customer/Action/list__action__transfer_warranty_ownership.html.twig' ] ];
		}
		$actions = array_merge($actions, array(
			'show'   => array(),
			'edit'   => array(),
			'delete' => array(),
//					'send_evoucher' => array( 'template' => '::admin/employer/employee/list__action_send_evoucher.html.twig' )

//                ,
//                    'view_description' => array('template' => '::admin/product/description.html.twig')
//                ,
//                    'view_tos' => array('template' => '::admin/product/tos.html.twig')
		));
		$listMapper->add('_action', 'actions', [
				'actions' => $actions,
				'label'   => 'form.label_action'
			]
		);
		
		$listMapper
			->add('name', null, [ 'editable' => true, 'label' => 'form.label_name' ])
			->add('email', null, [ 'editable' => true, 'label' => 'form.label_email' ])
			->add('telephone', null, [ 'editable' => true, 'label' => 'form.label_telephone' ])
			->add('homeAddress', null, [ 'editable' => true, 'label' => 'form.label_address' ])
			->add('subscribedToNewsletter','boolean',['label' => 'form.label_subscribed'])
			->add('enabled', null, [ 'editable' => true, 'label' => 'form.label_enabled' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$formMapper
			->with('form_group.customer_details', [ 'class' => 'col-md-12' ]);
		$formMapper
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('email', null, [ 'label' => 'form.label_email' ])
			->add('dialingCode', null, [ 'label' => 'form.label_dialing_code' ])
			->add('telephone', null, [ 'label' => 'form.label_telephone' ])
			->add('addressUnitNumber', null, [ 'label' => 'form.label_address_unit_number' ])
			->add('homeAddress', null, [ 'label' => 'form.label_address' ])
			->add('homePostalCode', null, [ 'required' => false, 'label' => 'form.label_postal_code' ])
//			->add('person.familyName',null,['label' => 'form.label_family_name' ])
//		           ->add('person.givenName',null,['label' => 'form.label_given_name' ])
			->add('enabled', null, [ 'label' => 'form.label_enabled' ]);
		$formMapper->end();
	}
	
	/**
	 * @param Customer $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param Customer $object
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
			->add('name');
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}
