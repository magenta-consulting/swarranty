<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Organisation;

use Doctrine\ORM\EntityRepository;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Product\ProductAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ManyToManyThingType;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\MediaCollectionType;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganisationMemberAdmin extends BaseAdmin {
	
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
		/** @var OrganisationMember $object */
		$object = parent::getNewInstance();
		if(empty($object->getPerson())) {
			$object->setPerson(new Person());
		}
		
		if(empty($user = $object->getPerson()->getUser())) {
			$object->getPerson()->setUser(new User());
		}
		
		return $object;
	}
	
	/**
	 * @param string             $name
	 * @param OrganisationMember $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof OrganisationMember
			? $object->getPerson()->getName()
			: 'OrganisationMember'; // shown in the breadcrumb on the create view
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
		$qb        = $query->getQueryBuilder();
		$rootAlias = $qb->getRootAliases()[0];
		
		//        $query->andWhere()
		
		{
			return $query;
		}
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
//		$collection->add('show_user_profile', $this->getRouterIdParameter() . '/show-user-profile');
		
	}
	
	public function getTemplate($name) {
		$_name = strtoupper($name);
		if($_name === 'LIST') {
		}
		
		return parent::getTemplate($name);
	}
	
	protected function configureShowFields(ShowMapper $showMapper) {
		$showMapper
			->with('form_group.OrganisationMember_details', [ 'class' => 'col-md-6' ])
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('email', null, [ 'label' => 'form.label_email' ])
			->add('homeAddress', null, [ 'label' => 'form.label_address' ])
			->add('homePostalCode', null, [ 'label' => 'form.label_postal_code' ])
			->end()
			->with('form_group.OrganisationMember_records', [ 'class' => 'col-md-6' ])
			->add('warranties', null, [
				'label'               => false,
				'associated_property' => 'id',
				'template'            => '@MagentaSOrganisationMemberAdmin/Admin/OrganisationMember/OrganisationMember/CRUD/Association/show_one_to_many.html.twig'
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
			->add('person.name', null, [ 'editable' => true, 'label' => 'form.label_name' ])
			->add('email', null, [ 'editable' => true, 'label' => 'form.label_email' ])
			->add('role', null, [
				'editable'            => true,
				'label'               => 'form.label_role',
				'associated_property' => 'name'
			])
			->add('enabled', null, [ 'editable' => true, 'label' => 'form.label_enabled' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		/** @var ProxyQuery $productQuery */
		$acroleQuery = $this->getFilterByOrganisationQueryForModel(ACRole::class);
		
		$c = $this->getConfigurationPool()->getContainer();
		
		$passwordRequired = empty($this->subject);
		
		$formMapper
			->with('form_group.user_details', [ 'class' => 'col-md-6' ]);
		$formMapper
			->add('person.name', null, [ 'label' => 'form.label_name' ])
			->add('email', null, [
				'required' => true,
				'label'    => 'form.label_email'
			])
			->add('person.user.plainPassword', TextType::class, [
				'label'    => 'form.label_password',
				'required' => $passwordRequired
			])
			->add('role', ModelType::class, [
				'label'    => 'form.label_role',
				'btn_add'  => false,
				'property' => 'name',
				'query'    => $acroleQuery
			
			])
			->add('enabled');
		$formMapper->end();
	}
	
	/** @param OrganisationMember $object */
	public function preValidate(
		$object
	) {
		parent::preValidate($object);
		/** @var Person $p */
		if( ! empty($p = $object->getPerson())) {
			$u = $p->getUser();
			if( ! empty($u)) {
				if( ! empty($p->getEmail()) && $p->getEmail() !== $object->getEmail()) {
					$u->setPlainPassword(null);
				}
				if( ! empty($u->getPlainPassword()) && ! empty($u->getId())) {
//					$manager = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.default_entity_manager');
				}
			}
		}
		$object->setOrganization($this->getCurrentOrganisation());
	}
	
	/**
	 * @param OrganisationMember $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param OrganisationMember $object
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
			->add('person.name')//			->add('locked')
		;
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}