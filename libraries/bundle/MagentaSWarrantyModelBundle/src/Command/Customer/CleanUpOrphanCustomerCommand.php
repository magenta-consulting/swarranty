<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Magenta\Bundle\SWarrantyModelBundle\Command\Customer;

use Doctrine\ORM\EntityManager;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
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
class CleanUpOrphanCustomerCommand extends Command {
	protected static $defaultName = 'magenta:customer:clean-up-orphan';
	
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
			->setDescription('Clean up orphan Customers.');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$manager = $this->entityManager;
		$output->writeln('Cleaning up orphan Customers');
		$customerRepo = $this->registry->getRepository(Customer::class);
		$customers    = $customerRepo->findAll();
		/** @var Customer $c */
		foreach($customers as $c) {
			if($c->getRegistrations()->count() === 0) {
				$output->writeln($c->getName());
				$this->entityManager->remove($c);
				$this->entityManager->flush();
			}
		}
		
		$qb = $this->entityManager->createQueryBuilder();
		
		$qb->select('COUNT(c) as count, c as object')
		   ->from(Customer::class, 'c')
		   ->groupBy('c.email')
		   ->having('COUNT(c) > 1');
		
		$results = $qb->getQuery()->getResult();
		
		foreach($results as $r) {
			/** @var Customer $c */
			$c     = $r['object'];
			$email = $c->getEmail();
			
			$duplicatedCustomers = $customerRepo->findBy([ 'email' => $email ]);
			if(count($duplicatedCustomers) > 0) {
				/** @var Customer $originalCustomer */
				$originalCustomer = $duplicatedCustomers[0];
				
				for($i = count($duplicatedCustomers) - 1; $i > 0; $i --) {
					/** @var Customer $c */
					$c    = $duplicatedCustomers[ $i ];
					$regs = $c->getRegistrations();
					
					/** @var Registration $reg */
					foreach($regs as $reg) {
						$c->removeRegistration($reg);
						$originalCustomer->addRegistration($reg);
						$manager->persist($reg);
					}
					
					$warranties = $c->getWarranties();
					/** @var Warranty $w */
					foreach($warranties as $w) {
						$c->removeWarranty($w);
						$originalCustomer->addWarranty($w);
						$manager->persist($w);
					}
				}
				
				$originalCustomer->getRegistrations();
				$originalCustomer->getWarranties();
			}
		}
	}
}
