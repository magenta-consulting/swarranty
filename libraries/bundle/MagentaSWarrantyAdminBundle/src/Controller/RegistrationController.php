<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class RegistrationController extends Controller {
	public function verifyEmailAction(Request $request) {
	return new Response('hello');
	}
}