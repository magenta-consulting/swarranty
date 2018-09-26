<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Controller;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RegistrationController extends Controller {
	public function verifyEmailAction(Request $request) {
		$token = $request->get('token');
		$repo  = $this->getDoctrine()->getRepository(Customer::class);
		/** @var Customer $c */
		$c = $repo->findOneBy([ 'emailVerificationToken' => $token ]);
		if( ! empty($c)) {
			$c->setEmailVerified(true);
			$manager = $this->get('doctrine.orm.default_entity_manager');
			$manager->persist($c);
			$manager->flush($c);
		} else {
			throw new UnauthorizedHttpException('Invalid Token');
		}
		
		$regId = $request->query->getInt('reg');
		if(empty($regId)) {
			throw new UnauthorizedHttpException('Invalid Reg ID');
		}
		$regRepo = $this->getDoctrine()->getRepository(Registration::class);
		/** @var Registration $reg */
		$reg = $regRepo->find($regId);
		if(empty($reg)) {
			throw new UnauthorizedHttpException('Reg ID not found');
		}
		
		$o = $c->getOrganisation();
		if( ! $reg->isSubmitted()) {
			return new RedirectResponse($o->getProductRegUrl() . '/upload-receipt-image/' . $regId);
		}
		
		return new RedirectResponse($o->getProductRegUrl() . '/success/' . $regId);
		
	}
}
