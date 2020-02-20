<?php

namespace App\Repository;

use App\Entity\SousCategorieProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SousCategorieProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategorieProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategorieProduit[]    findAll()
 * @method SousCategorieProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategorieProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousCategorieProduit::class);
    }

    public function findBySlugAndParfume($slug, $parfume) {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT scp, p
            FROM App\Entity\SousCategorieProduit scp
            JOIN scp.produits p
            WHERE scp.slug = :slug AND p.parfume = :parfume'
        )->setParameter('slug', $slug)
         ->setParameter('parfume',$parfume);

        return $query->getSingleResult();
    }

    // /**
    //  * @return SousCategorieProduit[] Returns an array of SousCategorieProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SousCategorieProduit
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
