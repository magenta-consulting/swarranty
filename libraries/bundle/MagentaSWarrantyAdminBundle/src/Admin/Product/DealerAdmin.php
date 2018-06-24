<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Product;

use Doctrine\ORM\EntityRepository;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\AccessControl\ACLAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Dealer;
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

class DealerAdmin extends BaseAdmin {
	
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
		/** @var Dealer $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	/**
	 * @param string $name
	 * @param Dealer $object
	 */
	public function isGranted($name, $object = null) {
		return parent::isGranted($name, $object);
	}
	
	public function toString($object) {
		return $object instanceof Dealer
			? $object->getName()
			: 'Dealer'; // shown in the breadcrumb on the create view
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
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('enabled', null, [ 'editable' => true, 'label' => 'form.label_enabled' ]);

//		$listMapper->add('positions', null, [ 'template' => '::admin/user/list__field_positions.html.twig' ]);
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		
		$formMapper
			->with('form_group.product', [ 'class' => 'col-md-12' ]);
		$formMapper
			->add('name', null, [ 'label' => 'form.label_name' ])
			->add('enabled');
		$formMapper->end();
		
	}
	
	/**
	 * @param Dealer $object
	 */
	public function prePersist($object) {
		parent::prePersist($object);
		if( ! $object->isEnabled()) {
			$object->setEnabled(true);
		}
	}
	
	/**
	 * @param Dealer $object
	 */
	public function preUpdate($object) {
		$c = $this->getConfigurationPool()->getContainer();
		
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
