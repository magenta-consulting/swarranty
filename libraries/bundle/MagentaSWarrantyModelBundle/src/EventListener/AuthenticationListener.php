<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Magenta\Bundle\SWarrantyModelBundle\EventListener;

use Magenta\Bundle\SWarrantyModelBundle\Event\FilterUserResponseEvent;
use Magenta\Bundle\SWarrantyModelBundle\Event\UserEvent;
use Magenta\Bundle\SWarrantyModelBundle\Event\MagentaUserEvents;
use Magenta\Bundle\SWarrantyModelBundle\Security\LoginManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AuthenticationListener implements EventSubscriberInterface
{
	/**
	 * @var LoginManagerInterface
	 */
	private $loginManager;
	
	/**
	 * @var string
	 */
	private $firewallName;
	
	/**
	 * AuthenticationListener constructor.
	 *
	 * @param LoginManagerInterface $loginManager
	 * @param string                $firewallName
	 */
	public function __construct(LoginManagerInterface $loginManager, $firewallName)
	{
		$this->loginManager = $loginManager;
		$this->firewallName = $firewallName;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			MagentaUserEvents::REGISTRATION_COMPLETED => 'authenticate',
			MagentaUserEvents::REGISTRATION_CONFIRMED => 'authenticate',
			MagentaUserEvents::RESETTING_RESET_COMPLETED => 'authenticate',
		);
	}
	
	/**
	 * @param FilterUserResponseEvent  $event
	 * @param string                   $eventName
	 * @param EventDispatcherInterface $eventDispatcher
	 */
	public function authenticate(FilterUserResponseEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
	{
		try {
			$this->loginManager->logInUser($this->firewallName, $event->getUser(), $event->getResponse());
			
			$eventDispatcher->dispatch(MagentaUserEvents::SECURITY_IMPLICIT_LOGIN, new UserEvent($event->getUser(), $event->getRequest()));
		} catch (AccountStatusException $ex) {
			// We simply do not authenticate users which do not pass the user
			// checker (not enabled, expired, etc.).
		}
	}
}