<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Admin\Customer;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WarrantyAdminController extends BaseCRUDAdminController
{
    public function listAction()
    {
        $this->admin->setTemplate('list', '@MagentaSWarrantyAdmin/Admin/Customer/Warranty/CRUD/list.html.twig');

        return parent::listAction();
    }

    public function transferOwnershipAction($id = null, $customerId, Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var Warranty $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        $registry = $this->getDoctrine();
        $customerRepo = $registry->getRepository(Customer::class);
        /** @var Customer $customer */
        if (!empty($customer = $customerRepo->find($customerId))) {
            $oldC = $object->getCustomer();
            $oldC->removeWarranty($object);
            $customer->addWarranty($object);
        }
        $this->admin->getModelManager()->update($object);

        return $this->redirect($this->admin->generateObjectUrl('show', $object, ['action' => 'show']));
    }

    public function detailAction($id = null, Request $request)
    {
        //		$request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());
        /** @var Warranty $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        $customer = $object->getCustomer();
        $product = $object->getProduct();
        $image = $product->getImage();
        if (empty($psn = $object->getProductSerialNumber())) {
            $psn = '';
        }
        if (empty($image)) {
            $imageId = null;
            $afUrl = $rfUrl = '/bundles/sonatamedia/grey.png';
        } else {
            $imageId = $image->getId();
            $afUrl = $this->get('sonata.media.manager.media')->generatePrivateUrl($image->getId());
            $rfUrl = $this->get('sonata.media.manager.media')->generatePrivateUrl($image->getId(), 'reference');
        }
        $wp = $product->getWarrantyPeriod();
        if (empty($wp)) {
            $wp = '';
        }
        $ewp = $product->getExtendedWarrantyPeriod();
        if (empty($ewp)) {
            $ewp = '';
        }

        return new JsonResponse([
            'customer_name' => $customer->getName(),
            'customer_phone' => $customer->getTelephone(),
            'customer_email' => $customer->getEmail(),

            'customer_address' => $customer->getHomeAddress(),
            'customer_postal' => $customer->getHomePostalCode(),
            'product_serial_number' => $psn,
            'model_name' => $product->getName(),
            'model_number' => $product->getModelNumber(),
            'brand' => empty($product->getBrand()) ? '' : $product->getBrand()->getName(),
            'category' => empty($product->getCategory()) ? '' : $product->getCategory()->getName(),

            'id_image' => $imageId,
            'admin_format' => $afUrl,
            'reference_format' => $rfUrl,
            'warranty_period' => $wp,
            'extended_warranty_period' => $ewp,
        ]);
    }
}
