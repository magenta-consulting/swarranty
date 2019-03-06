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
use Magenta\Bundle\SWarrantyModelBundle\Entity\System\Thing;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Peter Bean <peter@magenta-wellness.com>
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
        if (0 === count($results)) {
            $output->writeln('No Duplicates found');
        }
        foreach ($results as $r) {
            /** @var Customer $c */
            $c = $r['object'];
            $email = $c->getEmail();

            if (empty($email)) {
                $output->write('Empty Email');
                return;
            }

            $duplicatedCustomers = $customerRepo->findBy(['email' => $email, 'enabled' => true]);
            if (count($duplicatedCustomers) > 0) {
                /** @var Customer $originalCustomer */
                $originalCustomer = $duplicatedCustomers[0];

                for ($i = count($duplicatedCustomers) - 1; $i > 0; --$i) {
                    /** @var Customer $c */
                    $c = $duplicatedCustomers[$i];
                    $output->writeln(sprintf('Merging customer %s to %s', $c->getName().'( '.$c->getId().' )', $originalCustomer->getName().'( '.$originalCustomer->getId().' )'));
                    $toBePersisted = $c->mergeWith($originalCustomer);
                    foreach ($toBePersisted as $persisted) {
                        /** @var Thing $object */
                        foreach ($persisted as $object) {
                            $output->writeln('Persisting merged entity '.$object->getName().' ('.$object->getId().') ');
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
