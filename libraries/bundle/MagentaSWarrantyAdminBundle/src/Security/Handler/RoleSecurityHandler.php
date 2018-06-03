<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Security\Handler;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\RoleSecurityHandler as BaseHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class RoleSecurityHandler extends BaseHandler {
	/**
	 * @var AuthorizationChecker
	 */
	protected $authorizationChecker;
	
	/** @var ContainerInterface $container */
	private $container;
	

	
}