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
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Filter\CallbackFilter;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductAdmin extends BaseAdmin {
	
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
		/** @var Product $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	/**
	 * @param string  $name
	 * @param Product $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof Product
			? $object->getName()
			: 'Product'; // shown in the breadcrumb on the create view
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
		$collection->add('detail', $this->getRouterIdParameter() . '/detail');
		
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
			->add('image', 'image', [ 'label' => 'form.label_image' ])
			->add('brand.name', null, [ 'label' => 'form.label_brand' ])
			->add('modelNumber', null, [ 'editable' => true, 'label' => 'form.label_model_number' ])
			->add('name', null, [ 'editable' => true, 'label' => 'form.label_model_name' ])
			->add('category.name', null, [ 'editable' => true, 'label' => 'form.label_category' ])
			->add('enabled', null, [ 'editable' => true, 'label' => 'form.label_enabled' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		/** @var ProxyQuery $productQuery */
		$brandQuery       = $this->getFilterByOrganisationQueryForModel(Brand::class);
		$categoryQuery    = $this->getFilterByOrganisationQueryForModel(BrandCategory::class);
		$subCategoryQuery = $this->getFilterByOrganisationQueryForModel(BrandSubCategory::class);
		
		$formMapper
			->with('form_group.product', [ 'class' => 'col-md-12' ]);
		$formMapper
			->add('image', MediaType::class, [
				'new_on_update' => false,
				'context'       => 'product_image',
				'provider'      => 'sonata.media.provider.image'
			])
			->add('name', null, [ 'label' => 'form.label_model_name' ])
			->add('modelNumber')
			->add('brand', ModelType::class, [
				'property' => 'name',
				'btn_add'  => false,
				'query'    => $brandQuery
			])
			->add('category', ModelType::class, [
				'label'    => 'form.label_category',
				'property' => 'name',
				'btn_add'  => false,
				'query'    => $categoryQuery
			])
			->add('subCategory', ModelType::class, [
				'required' => false,
				'label'    => 'form.label_subcategory',
				'property' => 'name',
				'btn_add'  => false,
				'query'    => $subCategoryQuery
			])
			->add('warrantyPeriod', IntegerType::class, [])
			->add('extendedWarrantyPeriod', IntegerType::class, [ 'required' => false ])
			->add('enabled');
		$formMapper->end();
		
	}
	
	/**
	 * @param Product $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param Product $object
	 */
	public function preUpdate($object) {
		$c = $this->getConfigurationPool()->getContainer();
//		if(!empty($object->get))
		$mr = $c->get('doctrine')->getRepository(Media::class);
		if( ! empty($media = $mr->findOneBy([ 'imageProduct' => $object->getId() ]))) {
			if($media !== $object->getImage()) {
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
			->add('name')
//			->add('searchText','doctrine_orm_callback')
			->add('searchText', CallbackFilter::class, array(
				'show_filter' => false,
				'label'       => 'list.label_id',
//                'callback'   => array($this, 'getWithOpenCommentFilter'),
				'callback'    => function($queryBuilder, $alias, $field, $value) {
					if( ! $value['value']) {
						return;
					}
					
					/** @var QueryBuilder $queryBuilder */
					$expr = $queryBuilder->expr();

//					$queryBuilder->leftJoin(sprintf('%s.comments', $alias), 'c');
//					$queryBuilder->andWhere('c.status = :status');
//					$queryBuilder->andWhere(
//						$expr->eq(sprintf('%s.organisation', $alias), ':orgId')
//					);
//					$queryBuilder->setParameter('orgId', 2);
					
					return true;
				}
//				'field_type'  => 'text'
			))//			->add('locked')
		;
		parent::configureDatagridFilters($filterMapper);
	}
	
	
}
