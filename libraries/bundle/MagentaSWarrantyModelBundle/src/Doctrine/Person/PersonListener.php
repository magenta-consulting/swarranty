<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Doctrine\Person;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Person\Person;
use Magenta\Bundle\SWarrantyModelBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PersonListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function updateInfoAfterOperation(Person $person, LifecycleEventArgs $event)
    {
        $this->updateInfo($person, $event);
        $manager = $event->getEntityManager();
        $registry = $this->container->get('doctrine');
    }

    private function updateInfo(Person $person, LifecycleEventArgs $event)
    {
    }

    private function updateInfoBeforeOperation(Person $person, LifecycleEventArgs $event)
    {
        $this->updateInfo($person, $event);
        /** @var EntityManager $manager */
        $manager = $event->getObjectManager();
        $registry = $this->container->get('doctrine');

        $personRepo = $registry->getRepository(Person::class);

        $uow = $manager->getUnitOfWork();
    }

    public function preFlushHandler(Person $person, PreFlushEventArgs $event)
    {
        $manager = $event->getEntityManager();
        $registry = $this->container->get('doctrine');
        $email = $person->getEmail();
    }

    public function preUpdateHandler(Person $person, LifecycleEventArgs $event)
    {
        $this->updateInfoBeforeOperation($person, $event);
    }

    public function postUpdateHandler(Person $person, LifecycleEventArgs $event)
    {
        $this->updateInfoAfterOperation($person, $event);
    }

    public function prePersistHandler(Person $person, LifecycleEventArgs $event)
    {
        $this->updateInfoBeforeOperation($person, $event);
    }

    public function postPersistHandler(Person $person, LifecycleEventArgs $event)
    {
        $this->updateInfoAfterOperation($person, $event);
        /** @var EntityManager $manager */
        $manager = $event->getObjectManager();
        $registry = $this->container->get('doctrine');
        $personRepo = $registry->getRepository(Person::class);
        $userRepo = $registry->getRepository(User::class);
        $email = $person->getEmail();
        $uow = $manager->getUnitOfWork();
        $personCS = $uow->getEntityChangeSet($person);
        if (!$person->isSystemUser()) {
            // person null - user null
            if (empty($pu = $person->getUser())) {
                $pu = $person->initiateUser();
                $manager->persist($pu);
                $manager->flush($pu);
            } else {
                $uow->computeChangeSet($manager->getClassMetadata(User::class), $pu);
                $pu = $person->initiateUser();
                $uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(User::class), $pu);
            }

            /** @var User $user */
            $user = $userRepo->findOneBy(['email' => $email]);
            if (!empty($user)) {
                $pu->setPerson(null);
                $manager->detach($pu);
                $person->setUser($user);
                //				$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(Person::class), $person);
                $manager->persist($user);
                //				$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(User::class), $user);
            }
        } else {
            $pu = $person->getUser();
            $pu->addRole(User::ROLE_POWER_USER);
            $pu->setEmail($email);
            $manager->persist($pu);
            //			$uow->recomputeSingleEntityChangeSet($manager->getClassMetadata(User::class), $pu);
        }
    }

    public function preRemoveHandler(Person $person, LifecycleEventArgs $event)
    {
    }

    public function postRemoveHandler(Person $person, LifecycleEventArgs $event)
    {
    }
}
