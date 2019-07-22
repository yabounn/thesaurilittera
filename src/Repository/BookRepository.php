<?php

namespace App\Repository;

use App\Entity\Book;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;


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


    /**
     * Undocumented function
     *
     * @param [type] $array
     * @return void
     */
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
     * Recherche par titre du livre ou auteur
     * 
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

    /**
     * Renvoie de façon aléatoire un livre
     *
     * @return void
     */
    public function bookInTheRandom()
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Book::class, 'title');
        $sql = "SELECT * FROM book ORDER BY RAND() LIMIT 1";
        return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getOneOrNullResult();
    }
}
