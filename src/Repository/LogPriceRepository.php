<?php

namespace App\Repository;

use App\Entity\LogPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LogPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogPrice[]    findAll()
 * @method LogPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogPriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LogPrice::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('l')
            ->where('l.something = :value')->setParameter('value', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
