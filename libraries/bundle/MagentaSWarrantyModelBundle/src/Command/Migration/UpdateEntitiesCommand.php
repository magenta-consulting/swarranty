<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Command\Migration;

use Doctrine\ORM\EntityManager;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\CaseAppointment;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\FullTextSearchInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateEntitiesCommand extends Command {
	
	protected static $defaultName = 'magenta:migration:update-entities';
	
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
			->setDescription('Migrate data.')
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
		$em       = $this->entityManager;
		$entities = $em->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
		
		foreach($entities as $class) {
			$output->writeln($class);
			$rc = new \ReflectionClass($class);
			if( ! $rc->isAbstract()) {
				if(is_subclass_of($class, FullTextSearchInterface::class)) {
					$output->writeln('Updating ' . $class);
					$repo    = $this->registry->getRepository($class);
					$objects = $repo->findAll();
					$output->writeln(sprintf('>>>>> Re-generate %s for full-text search', $class));
					/** @var FullTextSearchInterface $object */
					foreach($objects as $object) {
						$object->generateSearchText();
						$object->generateFullText();
						$em->persist($object);
						$output->writeln('Flushing object ' . $object->getFullText());
						$em->flush($object);
						
					}
				}
//				if($class === CaseAppointment::class) {
//					$repo    = $this->registry->getRepository($class);
//					$objects = $repo->findAll();
//					$output->writeln(sprintf('>>>>> Re-generate %s for full-text search', $class));
//					/** @var CaseAppointment $object */
//					foreach($objects as $object) {
//						if(empty($object->getServiceSheet())) {
//							$object->setServiceSheet($object->createServiceSheet());
//						}
//						$em->persist($object->getServiceSheet());
//					}
//				}
			} else {
				$output->writeln($class . ' is Abstract');
			}
		}
		$output->writeln('Flushing ALL data...');
		$em->flush();
		$output->writeln('DONE');
	}
}