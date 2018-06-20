<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Product;

use Doctrine\ORM\EntityRepository;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Form\Type\ManyToManyThingType;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSubCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandSupplier;
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

class BrandAdmin extends BaseAdmin {
	
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
		/** @var Brand $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	/**
	 * @param string $name
	 * @param Brand  $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof Brand
			? $object->getName()
			: 'Brand'; // shown in the breadcrumb on the create view
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
			->add('name', null, [ 'editable' => true, 'label' => 'form.label_name' ])
			->add('enabled', null, [ 'editable' => true, 'label' => 'form.label_enabled' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$formMapper
			->tab('form_tab.general')
			->with('form_group.brand', [ 'class' => 'col-md-12' ]);
		$formMapper->add('name')
		           ->add('logo', MediaType::class, [
			           'new_on_update' => false,
			           'context'       => 'brand_logo',
			           'provider'      => 'sonata.media.provider.image'
		           ])
		           ->add('enabled')
		           ->end();
//		$formMapper->end();
//		$formMapper
//			->tab('form_tab.associated_categories_and_suppliers');
		$formMapper->with('form_group.categories', [ 'class' => 'col-md-4' ])
		           ->add('categories', ManyToManyThingType::class, [
			           'label'           => false,
			           'router_id_param' => 'childId',
			           'create_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandcategory_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'childId'   => 0,
					           'operation' => 'create'
				           ]
			           ],
			           'update_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandcategory_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'operation' => 'update'
				           ]
			           ],
			           'delete_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandcategory_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'operation' => 'delete'
				           ]
			           ],
			           'class'           => BrandCategory::class,
			           'query_builder'   => function(EntityRepository $er) {
				           $qb   = $er->createQueryBuilder('c');
				           $expr = $qb->expr();
				           $qb->andWhere($expr->eq('c.organisation', $this->getCurrentOrganisation()->getId()));
				
				           return $qb;
			           }
		           ])
		           ->end()
		           ->with('form_group.subcategories', [ 'class' => 'col-md-4' ])
		           ->add('subCategories', ManyToManyThingType::class, [
			           'label'           => false,
			           'class'           => BrandSubCategory::class,
			           'router_id_param' => 'childId',
			           'create_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandsubcategory_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'childId'   => 0,
					           'operation' => 'create'
				           ]
			           ],
			           'update_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandsubcategory_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'operation' => 'update'
				           ]
			           ],
			           'delete_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandsubcategory_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'operation' => 'delete'
				           ]
			           ],
			           'query_builder'   => function(EntityRepository $er) {
				           $qb   = $er->createQueryBuilder('c');
				           $expr = $qb->expr();
				           $qb->andWhere($expr->eq('c.organisation', $this->getCurrentOrganisation()->getId()));
				
				           return $qb;
			           }
		           ])
		           ->end()
		           ->with('form_group.suppliers', [ 'class' => 'col-md-4' ])
		           ->add('suppliers', ManyToManyThingType::class, [
			           'label'           => false,
			           'class'           => BrandSupplier::class,
			           'router_id_param' => 'childId',
			           'create_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandsupplier_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'childId'   => 0,
					           'operation' => 'create'
				           ]
			           ],
			           'update_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandsupplier_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'operation' => 'update'
				           ]
			           ],
			           'delete_route'    => [
				           'route_name'   => 'admin_magenta_swarrantymodel_organisation_organisation_product_brandsupplier_crud',
				           'route_params' => [
					           'id'        => $this->getCurrentOrganisation()->getId(),
					           'operation' => 'delete'
				           ]
			           ],
			           'query_builder'   => function(EntityRepository $er) {
				           $qb   = $er->createQueryBuilder('c');
				           $expr = $qb->expr();
				           $qb->andWhere($expr->eq('c.organisation', $this->getCurrentOrganisation()->getId()));
				
				           return $qb;
			           }
		           ])
//			->end()
                   ->end();
		
	}
	
	/**
	 * @param Brand $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param Brand $object
	 */
	public function preUpdate($object) {
		$c  = $this->getConfigurationPool()->getContainer();
		$mr = $c->get('doctrine')->getRepository(Media::class);
		if( ! empty($media = $mr->findOneBy([ 'logoBrand' => $object->getId() ]))) {
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
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}
