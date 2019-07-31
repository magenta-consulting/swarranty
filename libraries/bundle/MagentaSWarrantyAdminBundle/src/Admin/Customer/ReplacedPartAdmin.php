<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceNote;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\ServiceSheet;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReplacedPartAdmin extends BaseAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        parent::configureDatagridFilters($filter);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
    }

    public function toString(
        $object
    ) {
        return $object instanceof ServiceSheet
            ? $object->getId().' '.$object->getCreatedAt()->format('d-m-Y')
            : parent::toString($object); // shown in the breadcrumb on the create view
    }

    public function getNewInstance()
    {
        /** @var ServiceNote $object */
        $object = parent::getNewInstance();

        return $object;
    }

    public function isGranted(
        $name, $object = null
    ) {
        return parent::isGranted($name, $object);
    }

    public function createQuery(
        $context = 'list'
    ) {
        $query = parent::createQuery($context);
        $parentFD = $this->getParentFieldDescription();

        return $query;
//        $query->andWhere()
    }

    public function getPersistentParameters()
    {
        $parameters = parent::getPersistentParameters();
        if (!$this->hasRequest()) {
            return $parameters;
        }

        if (empty($org = $this->getCurrentOrganisation(false))) {
            return $parameters;
        }

        return array_merge($parameters, [
            'organisation' => $org->getId(),
        ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $c = $this->getConfigurationPool()->getContainer();
        /** @var ProxyQuery $productQuery */
        $apmtQuery = $this->getModelManager()->createQuery(CaseAppointment::class);
        /** @var Expr $expr */
        $expr = $apmtQuery->expr();
        /** @var QueryBuilder $qb */
        $qb = $apmtQuery->getQueryBuilder();
        $caseId = $this->getRequest()->query->getInt('case', 0);
        if (empty($caseId)) {
            /** @var ServiceNote $ss */
            if (!empty($ss = $this->subject)) {
                if (!empty($case = $ss->getCase())) {
                    $caseId = $case->getId();
                }
            }
        }

        $apmtQuery->andWhere($expr->eq('o.case', $caseId));
        $formMapper->add('name', TextType::class, ['required' => false]);
        $formMapper->add('code', TextType::class, ['required' => false]);
        $formMapper->add('quantity', NumberType::class, ['required' => false]);
        $formMapper->add('amount', MoneyType::class, ['required' => false]);
        $formMapper->add('remarks', TextType::class, ['required' => false]);
    }

    protected function verifyDirectParent(
        $parent
    ) {
    }

    /**
     * @param ServiceNote $object
     */
    public function preValidate(
        $object
    ) {
    }
}
