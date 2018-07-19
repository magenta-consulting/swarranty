<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Security\Handler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutHandler implements LogoutSuccessHandlerInterface {
	public function onLogoutSuccess(Request $request) {
		return new RedirectResponse('http://fujioh.com/sg/');
	}
}