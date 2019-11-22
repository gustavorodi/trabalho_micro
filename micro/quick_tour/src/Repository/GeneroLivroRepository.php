<?php

namespace App\Repository;

use App\Entity\GeneroLivro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GeneroLivro|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneroLivro|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneroLivro[]    findAll()
 * @method GeneroLivro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneroLivroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneroLivro::class);
    }

    // /**
    //  * @return GeneroLivro[] Returns an array of GeneroLivro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneroLivro
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
