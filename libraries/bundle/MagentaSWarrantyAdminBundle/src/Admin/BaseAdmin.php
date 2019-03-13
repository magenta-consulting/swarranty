<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Expr;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\Organisation\OrganisationAdmin;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\OrganisationMember;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearchInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\ThingChildInterface;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BaseAdmin extends AbstractAdmin
{
    const AUTO_CONFIG = true;
    const ENTITY = null;
    const CONTROLLER = null;
    const CHILDREN = null;

    const ADMIN_CODE = null;

    private $isAdmin;
    private $user;

    protected function getTemplateType($name)
    {
        $_name = strtoupper($name);
        if ('EDIT' === $_name) {
            if (empty($subject = $this->getSubject()) || empty($subject->getId())) {
                return 'CREATE';
            } else {
                return 'EDIT';
            }
        }

        return $_name;
    }

    /**
     * @deprecated since 3.34, will be dropped in 4.0. Use TemplateRegistry services instead
     *
     * @param string $name
     *
     * @return null|string
     */
    public function getTemplate($name)
    {
        return $this->getTemplateRegistry()->getTemplate($name);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        parent::configureDatagridFilters($filter);
        if (is_subclass_of($this->getClass(), FullTextSearchInterface::class)) {
            $filter->add('fullText', null, [
                'label' => 'form.label_full_text_search',
                'show_filter' => true,
            ]);
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('decide', $this->getRouterIdParameter().'/decide/{action}');
    }

    protected function buildShow()
    {
        parent::buildShow();
        /** @var FieldDescription $fieldDescription */
        foreach ($this->showFieldDescriptions as $fieldDescription) {
            switch ($fieldDescription->getMappingType()) {
//				case ClassMetadata::MANY_TO_ONE:
//					$fieldDescription->setTemplate(
//						'@SonataAdmin/CRUD/Association/list_many_to_one.html.twig'
//					);
//
//					break;
                case ClassMetadata::ONE_TO_ONE:
                    $fieldDescription->setTemplate(
                        '@MagentaSWarrantyAdmin/CRUD/Association/show_one_to_one.html.twig'
                    );

                    break;
                case ClassMetadata::ONE_TO_MANY:
                    $fieldDescription->setTemplate(
                        '@MagentaSWarrantyAdmin/CRUD/Association/show_one_to_many.html.twig'
                    );
                    break;
//				case ClassMetadata::MANY_TO_MANY:
//					$fieldDescription->setTemplate(
//						'@SonataAdmin/CRUD/Association/list_many_to_many.html.twig'
//					);
//
//					break;
            }
        }
    }

    protected function buildList()
    {
        parent::buildList();
        /** @var FieldDescription $fieldDescription */
        foreach ($this->listFieldDescriptions as $fieldDescription) {
            switch ($fieldDescription->getMappingType()) {
                case ClassMetadata::MANY_TO_ONE:
                    $fieldDescription->setTemplate(
                        '@MagentaSWarrantyAdmin/CRUD/Association/list_many_to_one.html.twig'
                    );
                    break;
                case ClassMetadata::ONE_TO_ONE:
                    $fieldDescription->setTemplate(
                        '@MagentaSWarrantyAdmin/CRUD/Association/list_one_to_one.html.twig'
                    );

                    break;
                case ClassMetadata::ONE_TO_MANY:
                    $fieldDescription->setTemplate(
                        '@MagentaSWarrantyAdmin/CRUD/Association/list_one_to_many.html.twig'
                    );
                    break;
//				case ClassMetadata::MANY_TO_MANY:
//					$fieldDescription->setTemplate(
//						'@SonataAdmin/CRUD/Association/list_many_to_many.html.twig'
//					);
//
//					break;
            }
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return [
            'xls',
        ];
    }

    //	public function generateUrl($name, array $parameters = array(), $absolute = UrlGeneratorInterface::ABSOLUTE_PATH) {
    //		if( ! empty($orgId = $this->getRequest()->query->getInt('organisation', 0))) {
    //			$org = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(Organisation::class)->find($orgId);
    //			if( ! empty($org)) {
    //				$parameters['organisation'] = $orgId;
    //			}
    //		}
//
    ////
    //		return parent::generateUrl($name, $parameters, $absolute);
    //	}

    protected function getCurrentOrganisationFromAncestors(BaseAdmin $parent = null)
    {
        if (empty($parent)) {
            return null;
        }
        if ($parent instanceof OrganisationAdmin) {
            return $parent->getSubject();
        }
        $grandpa = $parent->getParent();
        if ($grandpa instanceof OrganisationAdmin) {
            return $grandpa->getSubject();
        } else {
            return $this->getCurrentOrganisationFromAncestors($grandpa);
        }
    }

    protected function getCurrentOrganisationMember($required = false)
    {
        $user = $this->getLoggedInUser();
        $person = $user->getPerson();
        if (empty($person)) {
            return null;
        }

        return $person->getMemberOfOrganisation($this->getCurrentOrganisation());
    }

    /**
     * @return Organisation|null
     */
    protected function getCurrentOrganisation(
        $required = true
    ) {
        if (!empty($orgId = $this->getRequest()->query->getInt('organisation', 0))) {
            $org = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository(Organisation::class)->find($orgId);
        } else {
            $org = $this->getCurrentOrganisationFromAncestors($this->getParent());
        }

        if (empty($org)) {
            $user = $this->getLoggedInUser();
            if (empty($org = $user->getAdminOrganisation())) {
                if (!empty($person = $user->getPerson())) {
                    /** @var OrganisationMember $m */
                    $m = $person->getMembers()->first();
                    if (!empty($m)) {
                        $org = $m->getOrganization();
                    }
                }
            }
        }

        if (empty($org)) {
            if ($required) {
                throw new UnauthorizedHttpException('Unauthorised access');
            }
        }

        return $org;
    }

    protected function getLoggedInUser()
    {
        if (null === $this->user) {
            $this->user = $this->getConfigurationPool()->getContainer()->get(UserService::class)->getUser();
        }

        return $this->user;
    }

    protected function isAdmin()
    {
        if (null === $this->isAdmin) {
            $this->isAdmin = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        }

        return $this->isAdmin;
    }

    protected $translationDomain = 'MagentaSWarrantyAdmin'; // default is 'messages'

    protected $action = '';
    protected $actionParams = [];

    public function getAction()
    {
        if (empty($this->action)) {
            $request = $this->getRequest();
            if (!empty($action = $request->query->get('action'))) {
                $this->action = $action;
            }
        }

        return $this->action;
    }

    public function getActionParam(
        $key
    ) {
        if (array_key_exists($key, $this->actionParams)) {
            return $this->actionParams[$key];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getActionParams()
    {
        return $this->actionParams;
    }

    /**
     * @param array $actionParams
     */
    public function setActionParams(
        $actionParams
    ) {
        $this->actionParams = $actionParams;
    }

    public function setAction(
        $action
    ) {
        $this->action = $action;
    }

    public function toString(
        $object
    ) {
        if (method_exists($object, 'getTitle')) {
            return $object->getTitle();
        } elseif (method_exists($object, 'getName')) {
            return $object->getName();
        }

        return parent::toString($object);
    }

    public function getRequest()
    {
        if (!$this->request) {
//            throw new \RuntimeException('The Request object has not been set');
            $this->request = $this->getConfigurationPool()->getContainer()->get('request_stack')->getCurrentRequest();
        }

        return $this->request;
    }

    protected function getAccess()
    {
        return array_merge(parent::getAccess(), [
            'decide' => 'DECIDE',
            'decide_everything' => 'DECIDE_ALL',
            'approve' => 'DECISION_'.DecisionMakingInterface::DECISION_APPROVE,
            'reject' => 'DECISION_'.DecisionMakingInterface::DECISION_REJECT,
            'reset' => 'DECISION_'.DecisionMakingInterface::DECISION_RESET,
        ]);
    }

    public function isGranted(
        $name, $object = null
    ) {
        $container = $this->getConfigurationPool()->getContainer();
        $user = $container->get(UserService::class)->getUser();
        $isAdmin = $container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');

//        $pos = $container->get(UserService::class)->getPosition();
        if ($isAdmin) {
            //			if(is_array($name)) {
            //				foreach($name as $action) {
            //					$_name = strtoupper($name);
            //				}
            //			}
            if (in_array($name, ['LIST', 'EDIT', 'DELETE', 'CREATE', 'VIEW'])) {
                if ('CREATE' === $name) {
                    return !empty($this->getCurrentOrganisation(false));
                }

                return true;
            }
        }

        $org = $this->getCurrentOrganisation(false);
        $member = $this->getCurrentOrganisationMember(false);
        if (is_array($name)) {
            $isGranted = true;
            foreach ($name as $action) {
                $_isGranted = $user->isGranted($action, $object, $this->getClass(), $member, $org);
                $isGranted = $isGranted && $_isGranted;
            }

            return $isGranted;
        }

        return $user->isGranted($name, $object, $this->getClass(), $member, $org);

        //		return parent::isGranted($name, $object);
    }

    protected function getFilterByOrganisationQueryForModel(
        $class
    ) {
        /** @var ProxyQuery $productQuery */
        $brandQuery = $this->getModelManager()->createQuery($class);
        /** @var Expr $expr */
        $expr = $brandQuery->expr();
        $orgFieldName = 'organisation';
        if (OrganisationMember::class === $class) {
            $orgFieldName = 'organization';
        }
        $brandQuery->andWhere($expr->eq('o.'.$orgFieldName, $this->getCurrentOrganisation()->getId()));

        return $brandQuery;
    }

    public function createQuery(
        $context = 'list'
    ) {
        $query = parent::createQuery($context);
        $parentFD = $this->getParentFieldDescription();
        if ($this->isAdmin()) {
            //			if($this->getRequest()->attributes->get('_route') !== 'sonata_admin_retrieve_autocomplete_items') {
            // admin should see everything except in embeded forms
            if (in_array($this->getClass(), [
                    Organisation::class,
                    User::class,
                ]) || !empty($parentFD) && ModelAutocompleteType::class !== $parentFD->getType()) {
                return $query;
            }
        }

        $organisation = $this->getCurrentOrganisation();

        if (!empty($organisation)) { // && ! empty($organisation)
            $this->filterQueryByOrganisation($query, $organisation);
        } else {
            // TODO: change this so that 1 person can manage multiple organisations
            $this->clearResults($query);
        }

        return $query;
//        $query->andWhere()
    }

    protected function filterQueryByOrganisation(
        ProxyQuery $query, Organisation $organisation
    ) {
        $pool = $this->getConfigurationPool();
        $request = $this->getRequest();
        $container = $pool->getContainer();
        /** @var Expr $expr */
        $expr = $query->getQueryBuilder()->expr();
        $orgField = 'organisation';
        if (OrganisationMember::class === $this->getClass()) {
            $orgField = 'organization';
        }

        return $query->andWhere($expr->eq('o.'.$orgField, $organisation->getId()));
    }

    /**
     * @param ProxyQuery $query
     *
     * @return ProxyQuery
     */
    protected function clearResults(
        ProxyQuery $query
    ) {
        /** @var Expr $expr */
        $expr = $query->getQueryBuilder()->expr();
        $query->andWhere($expr->eq($expr->literal(true), $expr->literal(false)));

        return $query;
    }

    protected function verifyDirectParent(
        $parent
    ) {
    }

    protected function isDirectParentAccess(
        $parentClass, $subjectAdminCodes = []
    ) {
        $parentAdmin = $this->getParent();
        $isDirectParentAccess = false;
        if (!empty($parentAdmin)) {
            $_parentClass = $parentAdmin->getClass();
            $isDirectParentAccess = $parentClass === $_parentClass;
            if (!empty($subjectAdminCodes)) {
                $isDirectParentAccess = $isDirectParentAccess && (in_array($this->getCode(), $subjectAdminCodes));
            }
        }

        return $isDirectParentAccess;
    }

    protected function isAppendFormElement()
    {
        $request = $this->getRequest();

        return 'sonata_admin_append_form_element' === $request->attributes->get('_route');
    }

    protected function filterByParentClass(
        ProxyQuery $query, $parentClass, $subjectAdminCodes = []
    ) {
        $pool = $this->getConfigurationPool();
        $request = $this->getRequest();
        $container = $pool->getContainer();
        /** @var Expr $expr */
        $expr = $query->getQueryBuilder()->expr();

        $isDirectParentAccess = $this->isDirectParentAccess($parentClass, $subjectAdminCodes);
        $parentAdmin = $this->getParent();
        $rootAlias = $query->getRootAliases()[0];
        if ($isDirectParentAccess) {
            if ($this->verifyDirectParent($parentAdmin->getSubject())) {
                $query->andWhere($expr->eq($rootAlias.'.'.$this->getParentAssociationMapping(), $parentAdmin->getSubject()->getId()));

                return $query;
            }
        } else {
            if ($this->isAppendFormElement()) {
                // Indirect Parent
                $code = $request->query->get('code');
                $objectId = $request->query->get('objectId');

                if (in_array($code, $subjectAdminCodes)) {
                    /** @var AdminInterface $childAdmin */
                    $childAdmin = $pool->getAdminByAdminCode($code);
                    $child = $this->getModelManager()->find($childAdmin->getClass(), $objectId);
                    $indirectParentAssociationMapping = $childAdmin->getParentAssociationMapping();
                    $parentGetter = 'get'.ucfirst($indirectParentAssociationMapping);
                    $indirectParent = $child->{$parentGetter}();
//                    definitely null =>
//                    $indirectParentAdmin = $childAdmin->getParent();
                    if (get_class($indirectParent) === $parentClass) {
                        $query->andWhere($expr->eq($rootAlias.'.'.$childAdmin->getParentAssociationMapping(), $indirectParent->getId()));

                        return $query;
                    }
                }
            } else {
                // Indirect Parent but with direct access NOT Ajax call
                $childAdmin = $pool->getAdminByAdminCode($request->attributes->get('_sonata_admin'));
                $query->andWhere($expr->eq($rootAlias.'.'.$childAdmin->getParentAssociationMapping(), $request->attributes->get('id')));

                return $query;
            }
        }

        return $this->clearResults($query);
    }

    public function getSystemModules()
    {
        $registry = $this->getConfigurationPool()->getContainer()->get('doctrine');
        $modules = $registry->getRepository(SystemModule::class)->findAll();

        return $modules;
    }

    /**
     * @param mixed $object
     */
    public function preValidate(
        $object
    ) {
        if ($object instanceof Thing) {
            $object->setOrganisation($this->getCurrentOrganisation());
        } elseif ($object instanceof ThingChildInterface) {
            $object->getThing()->setOrganisation($this->getCurrentOrganisation());
        }
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);
        if (method_exists($object, 'setUpdatedAt')) {
            $object->setUpdatedAt(new \DateTime());
        }
    }
}
