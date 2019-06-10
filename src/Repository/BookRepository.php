<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // public function findAllQuery()
    // {
    //     return $this->createQueryBuilder('b')
    //         ->orderBy('b.id', 'DESC');    
    // }

    public function findArray($array)
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->where('b.id IN (:array)')
            ->setParameter('array', $array)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $value
     * @return void
     */
    public function findByTitle($value)
    {
        return $this->createQueryBuilder('b')
            ->join('b.author', 'a')
            ->andWhere('b.title like :val')
            ->orWhere('a.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // public function findOneBySomeField($value): ?Book
    // {
    //     return $this->createQueryBuilder('b')
    //         ->andWhere('b.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

}
