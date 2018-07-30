<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Magenta\Bundle\SWarrantyModelBundle\Command\Notification;

use Doctrine\ORM\EntityManager;
use Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl\ACRole;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\CaseModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\CommunicationTemplateModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\CustomerModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\DealerModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\ProductModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\SystemConfigModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\UserModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Module\WarrantyModule;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\System;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserManipulator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class NotifySystemCommand extends Command {
	
	protected static $defaultName = 'magenta:notif:system';
	
	/** @var RegistryInterface */
	private $registry;
	
	/** @var EntityManager */
	private $entityManager;
	
	public function __construct(RegistryInterface $registry, EntityManager $em) {
		parent::__construct();
		$this->registry      = $registry;
		$this->entityManager = $em;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this
			->setName(self::$defaultName)
			->setDescription('Notify System Command such as Tech Notif and CS new Reg Notif.')
			->setHelp(<<<'EOT'
The <info>magenta:notif:system</info> command creates a notif:

  <info>php %command.full_name% matthieu</info>

EOT
			);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$repo          = $this->registry->getRepository(SystemModule::class);
		$system        = $this->registry->getRepository(System::class)->find('magenta.swarranty');
		$organisations = $this->registry->getRepository(Organisation::class)->findBy([
			'enabled' => true,
			'system'  => $system
		]);
		
		$system->setLastNotifiedAt(new \DateTime());
		
		$system->notificationTypes[] = System::NOTIFICATION_TECHNICIAN_NEW_ASSIGNMENT;
		$system->notificationTypes[] = System::NOTIFICATION_WARRANTY_NEW_REGISTRATION;
		
		
		$this->entityManager->persist($system);
		$this->entityManager->flush($system);
		
		foreach($organisations as $org) {
//			$role = new ACRole();
//			$role->setOrganisation($org);
//			$role->setName('Technician');
//			$this->entityManager->persist($role);
		}
	}
}