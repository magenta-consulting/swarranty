<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Organisation\OrganisationAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceNote;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearchInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServiceNoteAdmin extends BaseAdmin {
	
	protected function configureDatagridFilters(DatagridMapper $filter) {
		parent::configureDatagridFilters($filter);
	}
	
	protected function configureRoutes(RouteCollection $collection) {
		parent::configureRoutes($collection);
	}
	
	public
	function toString(
		$object
	) {
		return $object instanceof ServiceSheet
			? $object->getId() . ' ' . $object->getCreatedAt()->format('d-m-Y')
			: parent::toString($object); // shown in the breadcrumb on the create view
	}
	
	public function getNewInstance() {
		/** @var ServiceNote $object */
		$object = parent::getNewInstance();
		
		return $object;
	}
	
	public
	function isGranted(
		$name, $object = null
	) {
		return parent::isGranted($name, $object);
	}
	
	public
	function createQuery(
		$context = 'list'
	) {
		$query    = parent::createQuery($context);
		$parentFD = $this->getParentFieldDescription();
		
		return $query;
//        $query->andWhere()
	}
	
	public function getPersistentParameters() {
		$parameters = parent::getPersistentParameters();
		if( ! $this->hasRequest()) {
			return $parameters;
		}
		
		if(empty($org = $this->getCurrentOrganisation(false))) {
			return $parameters;
		}
		
		return array_merge($parameters, array(
			'organisation' => $org->getId()
		));
	}
	
	protected function configureFormFields(FormMapper $formMapper) {
		$c = $this->getConfigurationPool()->getContainer();
		/** @var ProxyQuery $productQuery */
		$apmtQuery = $this->getModelManager()->createQuery(CaseAppointment::class);
		/** @var Expr $expr */
		$expr = $apmtQuery->expr();
		/** @var QueryBuilder $qb */
		$qb     = $apmtQuery->getQueryBuilder();
		$caseId = $this->getRequest()->query->getInt('case', 0);
		if(empty($caseId)) {
			/** @var ServiceNote $ss */
			if( ! empty($ss = $this->subject)) {
				if( ! empty($case = $ss->getCase())) {
					$caseId = $case->getId();
				}
			}
		}
		
		$apmtQuery->andWhere($expr->eq('o.case', $caseId));
		$formMapper->add('description', TextType::class);
		if($caseId > 0) {
			$formMapper->add('appointment', ModelType::class, [
				'required'    => false,
				'query'       => $apmtQuery,
				'placeholder' => 'Select Appointment',
				'property'    => 'searchText'
			]);
		}
	}
	
	protected
	function verifyDirectParent(
		$parent
	) {
		
	}
	
	/**
	 * @param ServiceNote $object
	 */
	public
	function preValidate(
		$object
	) {
		
	}
}