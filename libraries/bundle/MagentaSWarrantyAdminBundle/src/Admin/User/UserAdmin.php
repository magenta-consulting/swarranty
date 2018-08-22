<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\User;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\SecurityRolesType;
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

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserAdmin extends BaseAdmin {
//	const ADMIN_CODE = 'magenta_bundle_admin_user';
	
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
		/** @var User $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	/**
	 * @param string $name
	 * @param User   $object
	 */
	public function isGranted($name, $object = null) {
		$container = $this->getConfigurationPool()->getContainer();
		$isAdmin   = $container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
//        $pos = $container->get(UserService::class)->getPosition();
		if(in_array($name, [ 'CREATE', 'DELETE', 'LIST' ])) {
			return $isAdmin;
		}
		if($name === 'EDIT') {
			if($isAdmin) {
				return true;
			}
			if( ! empty($object) && $object->getId() === $container->get(UserService::class)->getUser()->getId()) {
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
		return $object instanceof User
			? $object->getEmail()
			: 'Talent'; // shown in the breadcrumb on the create view
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
//		$collection->add('show_user_profile', $this->getRouterIdParameter() . '/show-user-profile');
	
	}
	
	public function getTemplate($name) {
		$_name = strtoupper($name);
		
		return parent::getTemplate($name);
	}
	
	protected function configureShowFields(ShowMapper $showMapper) {
		$this->configureParentShowFields($showMapper);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureListFields(ListMapper $listMapper) {
		$listMapper->add('_action', 'actions', [
				'actions' => array(
//					'impersonate' => array( 'template' => 'admin/user/list__action__impersonate.html.twig' ),
					'edit'   => array(),
					'delete' => array(),
//					'send_evoucher' => array( 'template' => '::admin/employer/employee/list__action_send_evoucher.html.twig' )

//                ,
//                    'view_description' => array('template' => '::admin/product/description.html.twig')
//                ,
//                    'view_tos' => array('template' => '::admin/product/tos.html.twig')
				)
			]
		);
		$listMapper
			->addIdentifier('username')
			->add('email')
			->add('groups')
			->add('enabled', null, [ 'editable' => true ])
			->add('locked', null, [ 'editable' => true ])
			->add('createdAt');
		
		if($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
			$listMapper
				->add('impersonating', 'string', [ 'template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig' ]);
		}
		
		$listMapper->remove('impersonating');
		$listMapper->remove('groups');
//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	private function configureParentFormFields(FormMapper $formMapper) {
		
		// define group zoning
		$now = new \DateTime();
		
		$formMapper
			->with('General', [ 'class' => 'col-md-6' ])
			->add('username')
			->add('email')
			->add('plainPassword', TextType::class, [
				'required' => ( ! $this->getSubject() || is_null($this->getSubject()->getId())),
			])
//			->add('dob', DatePickerType::class, [
//				'years'       => range(1900, $now->format('Y')),
//				'dp_min_date' => '1-1-1900',
//				'dp_max_date' => $now->format('c'),
//				'format'      => 'dd/MM/yyyy',
//
//				'required' => false,
//			])

//			->add('biography', TextType::class, [ 'required' => false ])
//			->add('gender', 'Sonata\UserBundle\Form\Type\UserGenderListType', [
//				'required'           => true,
//				'translation_domain' => $this->getTranslationDomain(),
//			])
//			->add('locale', 'locale', [ 'required' => false ])
//			->add('timezone', 'timezone', [ 'required' => false ])

//			->with('Social')
//			->add('facebookUid', null, [ 'required' => false ])
//			->add('facebookName', null, [ 'required' => false ])
//			->add('twitterUid', null, [ 'required' => false ])
//			->add('twitterName', null, [ 'required' => false ])
//			->add('gplusUid', null, [ 'required' => false ])
//			->add('gplusName', null, [ 'required' => false ])
		;
		
		if($this->getSubject() && ! $this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
			$formMapper
//				->add('locked', null, [ 'required' => false ])
//				->add('expired', null, [ 'required' => false ])
				->add('enabled', null, [ 'required' => false ])
//				->add('credentialsExpired', null, [ 'required' => false ])

//				->with('Groups')
//				->add('groups', 'sonata_type_model', [
//					'required' => false,
//					'expanded' => true,
//					'multiple' => true,
//				])
				->end()
				->with('Authorisation', [ 'class' => 'col-md-6' ])
				->add('realRoles', SecurityRolesType::class, [
					'label'    => 'form.label_roles',
					'expanded' => true,
					'multiple' => true,
					'required' => false,
				])
				->end();
			$formMapper->end();
		}

//		$formMapper
//			->tab('Security')
//			->with('Keys')
//			->add('token', null, [ 'required' => false ])
//			->add('twoStepVerificationCode', null, [ 'required' => false ])
//			->end()
//			->end();
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		
		if($this->getConfigurationPool()->getContainer()->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
			$this->configureParentFormFields($formMapper);
		} else {
			$formMapper
				->with('Profile', [ 'class' => 'col-md-6' ])->end()
				->with('General', [ 'class' => 'col-md-6' ])->end();
			
			$formMapper
				->with('General')
//                ->add('username')
				->add('email', null, [ 'label' => 'form.label_email' ])
//                ->add('admin')
				->add('plainPassword', TextType::class, [
					'label'    => 'form.label_password',
					'required' => ( ! $this->getSubject() || is_null($this->getSubject()->getId())),
				])
				->end()
				->with('Profile');
			
			$formMapper
				->add('person.givenName', null, [ 'required' => false, 'label' => 'form.label_given_name' ])
				->add('person.familyName', null, [
					'required' => false,
					'label'    => 'form.label_family_name'
				])//				->add('roles', null, [ 'required' => false ])
			;
			
			$formMapper->end();
		}
		
	}
	
	/**
	 * @param User $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param User $object
	 */
	public function preUpdate($object) {
		
		$this->getUserManager()->updateCanonicalFields($object);
		$this->getUserManager()->updatePassword($object);
		
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	///////////////////////////////////
	///
	///
	///
	///////////////////////////////////
	/**
	 * @var UserManagerInterface
	 */
	protected $userManager;
	
	/**
	 * {@inheritdoc}
	 */
	public function getFormBuilder() {
		$this->formOptions['data_class'] = $this->getClass();
		
		$options                      = $this->formOptions;
		$options['validation_groups'] = ( ! $this->getSubject() || is_null($this->getSubject()->getId())) ? 'Registration' : 'Profile';
		
		$formBuilder = $this->getFormContractor()->getFormBuilder($this->getUniqid(), $options);
		
		$this->defineFormBuilder($formBuilder);
		
		return $formBuilder;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getExportFields() {
		// avoid security field to be exported
		return array_filter(parent::getExportFields(), function($v) {
			return ! in_array($v, [ 'password', 'salt' ]);
		});
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureDatagridFilters(DatagridMapper $filterMapper) {
		$filterMapper
			->add('id')
			->add('username')
//			->add('locked')
			->add('email');
//			->add('groups')
//		;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureParentShowFields(ShowMapper $showMapper) {
		$showMapper
			->with('General')
			->add('username')
			->add('email')
			->end()
			->with('Groups')
			->add('groups')
			->end()
			->with('Profile')
			->add('dateOfBirth')
			->add('firstname')
			->add('lastname')
			->add('website')
			->add('biography')
			->add('gender')
			->add('locale')
			->add('timezone')
			->add('phone')
			->end()
			->with('Social')
			->add('facebookUid')
			->add('facebookName')
			->add('twitterUid')
			->add('twitterName')
			->add('gplusUid')
			->add('gplusName')
			->end()
			->with('Security')
			->add('token')
			->add('twoStepVerificationCode')
			->end();
	}
	
	/**
	 * @return UserManagerInterface
	 */
	public function getUserManager() {
		if(empty($this->userManager)) {
			$this->userManager = $this->getConfigurationPool()->getContainer()->get('magenta_user.user_manager');
		}
		
		return $this->userManager;
	}
	
}
