<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Controller;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class RegistrationController extends Controller {
	public function verifyEmailAction(Request $request) {
		$token = $request->get('token');
		$repo  = $this->getDoctrine()->getRepository(Customer::class);
		$c     = $repo->findOneBy([ 'emailVerificationToken' => $token ]);
		if( ! empty($c)) {
			$c->setEmailVerified(true);
			$manager = $this->get('doctrine.orm.default_entity_manager');
			$manager->persist($c);
			$manager->flush($c);
		}
		
		return new Response('hello ' . $c->isEmailVerified());
	}
}