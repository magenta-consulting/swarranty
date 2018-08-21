<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Command\Migration;

use Doctrine\ORM\EntityManager;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Product\Product;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearchInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SwitchProductNameNumberCommand extends Command {
	
	protected static $defaultName = 'magenta:migration:switch-name-number';
	
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
			->setDescription('Switch Model Name and Number.')
			->setHelp(<<<'EOT'
The <info>magenta:migration:update-entities</info> command ......

EOT
			);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('retrieving class names');
		$em      = $this->entityManager;
		$repo    = $em->getRepository(Product::class);
		$objects = $repo->findAll();
		/** @var Product $object */
		foreach($objects as $object) {
			$number = $object->getModelNumber();
			$name   = $object->getName();
			$object->setModelNumber($name);
			$object->setName($number);
			$em->persist($object);
			$output->writeln(sprintf('model Name %s has been swapped with model Number %s', $name, $number));
		}
		$output->writeln('Flushing ALL data...');
		$em->flush();
		$output->writeln('DONE');
	}
}
