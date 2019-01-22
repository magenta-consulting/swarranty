<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin;

use Magenta\Bundle\SWarrantyModelBundle\Entity\System\DecisionMakingInterface;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserService;
use PhpOffice\PhpSpreadsheet\Writer\IWriter as PhpSpreadsheetIWriter;
use Sonata\AdminBundle\Templating\TemplateRegistryInterface;
use Symfony\Component\Form\FormView;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BaseCRUDAdminController extends CRUDController
{
    /**
     * Stream the file as Response.
     *
     * @param PhpSpreadsheetIWriter $writer
     * @param int                   $status
     * @param array                 $headers
     *
     * @return StreamedResponse
     */
    public function createSpreadsheetStreamedResponse(PhpSpreadsheetIWriter $writer, $status = 200, $headers = [])
    {
        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $status,
            $headers
        );
    }

    /**
     * @var BaseAdmin
     */
    protected $admin;

    protected $templateRegistry;

    protected function getTemplateRegistry()
    {
        $this->templateRegistry = $this->container->get($this->admin->getCode().'.template_registry');
        if (!$this->templateRegistry instanceof TemplateRegistryInterface) {
            throw new \RuntimeException(sprintf(
                'Unable to find the template registry related to the current admin (%s)',
                $this->admin->getCode()
            ));
        }

        return $this->templateRegistry;
    }

    protected function getDecision($action): ?string
    {
        $decision = null;
        if ('reset' === $action) {
            $decision = DecisionMakingInterface::DECISION_RESET;
        } elseif ('approve' === $action) {
            $decision = DecisionMakingInterface::DECISION_APPROVE;
        } elseif ('reject' === $action) {
            $decision = DecisionMakingInterface::DECISION_REJECT;
        }

        return $decision;
    }

    /**
     * Show action.
     *
     * @param int|string|null $id
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     *
     * @return Response
     */
    public function decideAction(
        $id = null, $action = 'show'
    ) {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        /** @var DecisionMakingInterface $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        if (!$object instanceof DecisionMakingInterface) {
            throw new AccessDeniedException(sprintf('unable to find the object with id: %s', $id));
        }

        $this->admin->checkAccess($action, $object);

        $preResponse = $this->preShow($request, $object);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        // NEXT_MAJOR: Remove this line and use commented line below it instead
        $template = $this->getTemplateRegistry()->getTemplate('decide');

        //		$template = $this->templateRegistry->getTemplate('show');

        if ($request->isMethod('post')) {
            $decision = $this->getDecision($action);

            $object->setDecisionRemarks($request->get('decision-remarks'));
            if (!empty($decision)) {
                $object->makeDecision($decision);
                $this->admin->update($object);
            }
        }

        if (!empty($res = $this->preRenderDecision($action, $object))) {
            return $res;
        }

        return $this->renderWithExtraParams($template, [
            'action' => $action,
            'object' => $object,
            'elements' => $this->admin->getShow(),
        ], null);
    }

    protected function preRenderDecision($action, $object)
    {
        if ('show' !== $action) {
            return $this->redirect($this->admin->generateObjectUrl('decide', $object, ['action' => 'show']));
        }
    }

    protected function getRefererParams()
    {
        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $baseUrl = $request->getBaseUrl();
        if (empty($baseUrl)) {
            return null;
        }
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));

        return $this->get('router')->match($lastPath);
        //		getMatcher()
    }

    protected function isAdmin()
    {
        return $this->get(UserService::class)->getUser()->isAdmin();
    }

    /**
     * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
     *
     * @param FormView $formView
     * @param string   $theme
     */
    protected function setFormTheme(
        FormView $formView, $theme
    ) {
        $twig = $this->get('twig');

        try {
            $twig
                ->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')
                ->setTheme($formView, $theme);
        } catch (\Twig_Error_Runtime $e) {
            // BC for Symfony < 3.2 where this runtime not exists
            $twig
                ->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')
                ->renderer
                ->setTheme($formView, $theme);
        }
    }
}
