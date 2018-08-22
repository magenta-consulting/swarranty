<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Magenta\Bundle\SWarrantyModelBundle\Command\Product;

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
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Brand;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\BrandCategory;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\System;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\SystemModule;
use Magenta\Bundle\SWarrantyModelBundle\Service\User\UserManipulator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class ImportProductCommand extends Command {
	
	protected static $defaultName = 'magenta:product:import';
	
	/** @var RegistryInterface */
	private $registry;
	
	/** @var EntityManager */
	private $entityManager;
	
	/** @var ContainerInterface $container */
	private $container;
	
	public function __construct(ContainerInterface $container, RegistryInterface $registry, EntityManager $em) {
		parent::__construct();
		$this->registry      = $registry;
		$this->entityManager = $em;
		$this->container     = $container;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this
			->setName(self::$defaultName)
			->setDescription('Importing Product List ...')
			->setHelp(<<<'EOT'
The <info>magenta:product:import</info> command creates a user:

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
		$filePath = $this->container->getParameter(
				'kernel.root_dir'
			) . '/../public/import/fujioh-product-list.xlsx';
		
		$reader = IOFactory::createReader("Xlsx")->load($filePath);
		$sheet  = $reader->getActiveSheet();
		$row    = 2;
		while(true) {
			$index = (int) $sheet->getCellByColumnAndRow(1, $row)->getValue();
			if($index === 0) {
				break;
			}
			
			$catStr = $sheet->getCellByColumnAndRow(2, $row)->getValue();
			if($catStr === 'HOOD') {
				$cat = $this->registry->getRepository(BrandCategory::class)->find(3);
			}
			if($catStr === 'OVEN') {
				$cat = $this->registry->getRepository(BrandCategory::class)->find(4);
			}
			if($catStr === 'GAS HOB') {
				$cat = $this->registry->getRepository(BrandCategory::class)->find(6);
			}
			if($catStr === 'INDUCTION HOB') {
				$cat = $this->registry->getRepository(BrandCategory::class)->find(7);
			}
			
			$brandStr = $sheet->getCellByColumnAndRow(3, $row)->getValue();
			if($brandStr === 'FUJIOH') {
				$brand = $this->registry->getRepository(Brand::class)->find(2);
			} elseif($brandStr === 'ARIAFINA') {
				$brand = $this->registry->getRepository(Brand::class)->find(3);
			}
			
			$name   = $sheet->getCellByColumnAndRow(4, $row)->getValue();
			$number = $sheet->getCellByColumnAndRow(5, $row)->getValue();
			
			$output->writeln([
				'col 1 row ' . $row . '   ' . $index,
				$sheet->getCellByColumnAndRow(1, $row)->getValue() . ' ' . $catStr . ' ' . $brandStr
			]);
			
			$product = new Product();
			$product->setBrand($brand);
			$product->setCategory($cat);
			$product->setWarrantyPeriod(12);
			$product->setExtendedWarrantyPeriod(3);
			$this->entityManager->persist($product);
			
			$row ++;
		}
		
		$this->entityManager->flush();
	}
}
