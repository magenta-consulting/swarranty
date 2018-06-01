<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Magenta\Bundle\SWarrantyModelBundle\Command\Module;

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
class InitiateModuleCommand extends Command {
	
	protected static $defaultName = 'magenta:module:init';
	
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
			->setDescription('Initate DB.')
			->setHelp(<<<'EOT'
The <info>magenta:module:init</info> command creates a user:

  <info>php %command.full_name% matthieu</info>

This interactive shell will ask you for an email and then a password.

You can alternatively specify the email and password as the second and third arguments:

  <info>php %command.full_name% matthieu matthieu@example.com mypassword</info>

You can create a super admin via the super-admin flag:

  <info>php %command.full_name% admin --super-admin</info>

You can create an inactive user (will not be able to log in):

  <info>php %command.full_name% thibault --inactive</info>

EOT
			);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$repo          = $this->registry->getRepository(SystemModule::class);
		$system        = $this->registry->getRepository(System::class)->find('magenta.swarranty');
		$organisations = $this->registry->getRepository(Organisation::class)->findBy([ 'enabled' => true ]);
		
		$modules = $repo->findAll();
		
		if( ! empty($system)) {
			$this->entityManager->remove($system);
		}
		/** @var SystemModule $module */
		foreach($modules as $module) {
			$this->entityManager->remove($module);
		}
		
		$this->entityManager->flush();
		$system = new System();
		$system->setId('magenta.swarranty');
		$this->entityManager->persist($system);
		
		$user = new UserModule();
		$user->setSystem($system);
		
		$case = new CaseModule();
		$case->setSystem($system);
		
		$ct = new CommunicationTemplateModule();
		$ct->setSystem($system);
		
		$customer = new CustomerModule();
		$customer->setSystem($system);
		
		$dealer = new DealerModule();
		$dealer->setSystem($system);
		
		$product = new ProductModule();
		$product->setSystem($system);
		
		$w = new WarrantyModule();
		$w->setSystem($system);
		
		$systemC = new SystemConfigModule();
		$systemC->setSystem($system);
		
		$this->entityManager->persist($user);
		$this->entityManager->persist($product);
		$this->entityManager->persist($w);
		$this->entityManager->persist($ct);
		$this->entityManager->persist($dealer);
		$this->entityManager->persist($case);
		$this->entityManager->persist($ct);
//		$this->entityManager->persist($systemC);
		
		foreach($organisations as $org) {
			$role = new ACRole();
			$role->setOrganisation($org);
			$role->setName('Technician');
			$this->entityManager->persist($role);
			$this->entityManager->flush();
		}
	}
}