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
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
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

class WarrantyChildCaseAdmin extends WarrantyCaseAdmin {
	
	const ENTITY = WarrantyCase::class;
	
	protected $baseRouteName = 'admin_magenta_customer_warrantychildcase';
	
	protected $baseRoutePattern = 'magenta/customer-warrantychildcase';
	
	protected $classnameLabel = 'child_case';
	
	protected function configureFormFields(FormMapper $formMapper) {
		parent::configureFormFields($formMapper);
		if( ! empty($parent = $this->getParent())) {
			/** @var WarrantyCase $parentCase */
			$parentCase = $parent->getSubject();
			$customerId = $parentCase->getWarranty()->getCustomer()->getId();
			
			$formMapper->remove('warranty');
			
			/** @var ProxyQuery $productQuery */
			$warrantiesFromSameCustomerQuery = $this->getModelManager()->createQuery(Warranty::class);
			/** @var Expr $expr */
			$expr = $warrantiesFromSameCustomerQuery->expr();
			/** @var QueryBuilder $wfscqb */
			$wfscqb        = $warrantiesFromSameCustomerQuery->getQueryBuilder();
			$wfscRootAlias = $wfscqb->getRootAliases()[0];
			
			$wfscqb->join('o.customer', 'customer');
			$wfscqb->andWhere($expr->andX(
				$expr->eq('customer.id', $expr->literal($customerId)),
//				$expr->eq('o.status', $expr->literal('APPROVED')),
				$expr->gte($wfscRootAlias . '.expiryDate', ':today')
			
			))
			       ->setParameter('today', new \DateTime());
			
			$formMapper
				->with('form_group.selected_warranty');
			$formMapper
				->add('warranty', ModelType::class, [
					'required'    => false,
					'placeholder' => 'Select a Warranty',
					'label'       => false,
					'property'    => 'product.name',
					'btn_add'     => false,
					'query'       => $warrantiesFromSameCustomerQuery
				]);
			$formMapper->end();
		}
	}
	
	protected
	function getAutocompleteRouteParameters() {
		if( ! empty($parent = $this->getParent())) {
			/** @var WarrantyCase $parentCase */
			$parentCase = $parent->getSubject();
			$customerId = $parentCase->getWarranty()->getCustomer()->getId();
			
			return array_merge(parent::getAutocompleteRouteParameters(), [
				'customer' => $customerId
			]);
		}
		
		return parent::getAutocompleteRouteParameters();
	}
	
}