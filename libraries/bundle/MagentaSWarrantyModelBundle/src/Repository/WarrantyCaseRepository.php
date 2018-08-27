<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Symfony\Bridge\Doctrine\RegistryInterface;

class WarrantyCaseRepository extends ServiceEntityRepository {
	public function __construct(RegistryInterface $registry) {
		parent::__construct($registry, WarrantyCase::class);
	}
	
	/**
	 * @param WarrantyCase $case
	 *
	 * @return int|null
	 */
	public function determineCaseMonthlyIncrement(WarrantyCase $case): ?int {
		// automatically knows to select Products
		// the "p" is an alias you'll use in the rest of the query
		$qb = $this->createQueryBuilder('_case');
		
		$createdAt = $case->getCreatedAt();
		$year      = (int) $createdAt->format('Y');
		$month     = (int) $createdAt->format('m');
		
		$monthStart = new \DateTime();
		$monthStart->setDate($year, $month, 1);
		
		$monthEnd = new \DateTime();
		$day      = (int) $createdAt->format('t');
		$monthEnd->setDate($year, $month, $day);
		
		$qb->andWhere('_case.createdAt BETWEEN :monthStart AND :monthEnd')
		   ->setParameter('monthStart', $monthStart->format('Y-m-d'))
		   ->setParameter('monthEnd', $monthEnd->format('Y-m-d'))
		   ->orderBy('_case.id', 'ASC');
		
		$query = $qb->getQuery();
		$dql = $query->getDQL();
		$sql = $query->getSQL();
		$cases     = $query->execute();
		
		$increment = 0;
		/** @var WarrantyCase $_case */
		foreach($cases as $_case) {
			$increment ++;
			if($_case === $case) {
				return $increment;
			}
		}
		
		return null;
		// to get just one result:
		// $product = $qb->setMaxResults(1)->getOneOrNullResult();
	}
}
