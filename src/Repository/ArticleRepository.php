<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findThreeRandom()
    {
        // Adjust the query depending on your database (MySQL example shown here)
        $query = $this->createQueryBuilder('p')
            ->orderBy('RAND()')
            ->setMaxResults(3)
            ->getQuery();

        return $query->getResult();
    }

    public function findByDateDESC()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.annee', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
