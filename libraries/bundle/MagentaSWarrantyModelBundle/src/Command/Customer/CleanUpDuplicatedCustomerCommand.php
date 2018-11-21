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
use Doctrine\ORM\Query\Expr\OrderBy;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Customer;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Registration;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
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
class CleanUpDuplicatedCustomerCommand extends Command
{
    protected static $defaultName = 'magenta:customer:clean-up-duplicates';
    
    /** @var RegistryInterface */
    private $registry;
    
    /** @var EntityManager */
    private $entityManager;
    
    public function __construct(RegistryInterface $registry, EntityManager $em)
    {
        parent::__construct();
        $this->registry = $registry;
        $this->entityManager = $em;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Clean up orphan Customers.');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->entityManager;
        $output->writeln('Cleaning up duplicated Customers');
        $customerRepo = $this->registry->getRepository(Customer::class);
        
        $qb = $this->entityManager->createQueryBuilder();
        $expr = $qb->expr();
        $qb->select('COUNT(c) as count, c as object')
            ->from(Customer::class, 'c')
            ->groupBy('c.email')
            ->having('COUNT(c) > 1')
            ->where($expr->eq('c.enabled', true));
        
        $results = $qb->getQuery()->getResult();
        if (count($results) === 0) {
            $output->writeln('No Duplicates found');
        }
        foreach ($results as $r) {
            /** @var Customer $c */
            $c = $r['object'];
            $email = $c->getEmail();
            
            $duplicatedCustomers = $customerRepo->findBy(['email' => $email, 'enabled' => true]);
            if (count($duplicatedCustomers) > 0) {
                /** @var Customer $originalCustomer */
                $originalCustomer = $duplicatedCustomers[0];
                
                for ($i = count($duplicatedCustomers) - 1; $i > 0; $i--) {
                    /** @var Customer $c */
                    $c = $duplicatedCustomers[$i];
                    $output->writeln(sprintf('Merging customer %s to %s', $c->getName() . '( ' . $c->getId() . ' )', $originalCustomer->getName() . '( ' . $originalCustomer->getId() . ' )'));
                    $toBePersisted = $c->mergeWith($originalCustomer);
                    foreach ($toBePersisted as $persisted) {
                        /** @var Thing $object */
                        foreach ($persisted as $object) {
                            $output->writeln('Persisting merged entity ' . $object->getName() . ' (' . $object->getId() . ') ');
                            $manager->persist($object);
                        }
                    }
                    
                }
                
                $output->writeln('Flushing');
                $manager->flush();
            }
        }
    }
}
