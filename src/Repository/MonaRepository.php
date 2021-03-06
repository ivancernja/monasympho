<?php

namespace App\Repository;

use App\Entity\Mona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mona|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mona|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mona[]    findAll()
 * @method Mona[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mona::class);
    }

    public function transform(Mona $mona)
{
    return [
            'id'    => (int) $mona->getId(),
            'title' => (string) $mona->getTitle(),
            'count' => (int) $mona->getCount()
    ];
}

public function transformAll()
{
    $mona = $this->findAll();
    $monaArray = [];

    foreach ($mona as $mona) {
        $monaArray[] = $this->transform($mona);
    }

    return $monaArray;
}

    // /**
    //  * @return Mona[] Returns an array of Mona objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mona
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
