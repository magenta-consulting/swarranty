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
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Peter Bean <peter@magenta-wellness.com>
 */
class ResendCustomerVerificationEmailCommand extends Command
{
    protected static $defaultName = 'magenta:customer:resend-customer-verification-email';

    /** @var RegistryInterface */
    private $registry;

    /** @var EntityManager */
    private $entityManager;

    /** @var \Swift_Mailer */
    private $mailer;

    public function __construct(RegistryInterface $registry, EntityManager $em, \Swift_Mailer $mailer)
    {
        parent::__construct();
        $this->registry = $registry;
        $this->entityManager = $em;
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Resend Customer Verification Emails.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->entityManager;
        $output->writeln('Resend Customer Verification Emails');
        $customerRepo = $this->registry->getRepository(Customer::class);

        $customers = $customerRepo->findBy(['emailVerified' => false,
        ]);
        if (0 === count($customers)) {
            $output->write('No Email to work with');
        }

        /** @var Customer $customer */
        foreach ($customers as $customer) {
            $c = $customer;
            $email = $c->getEmail();

            if (empty($email)) {
                $output->write('Empty Email from '.$c->getName());

                return;
            }

            /** @var Registration $reg */
            $reg = $c->getRegistrations()->last();
            if (empty($reg)) {
                $output->writeln('empty reg '.$c->getName());
                continue;
            }
            $msg = $reg->prepareEmailVerificationMessage();
            $email = $msg['recipient'];
            $customer = $reg->getCustomer();
            $message = (new \Swift_Message($msg['subject']))
                ->setFrom('no-reply@'.$customer->getOrganisation()->getSystem()->getDomain())
                ->setTo($email)
                ->setBody(
                    $msg['body'],
                    'text/html'
                )/*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;

            $output->writeln('Sending email to '.$email);
            $this->mailer->send($message);

            $output->writeln('Flushing');
            $manager->flush();
        }
    }
}
