<?php

namespace App\Repository;

use App\Entity\PictureIllustration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PictureIllustration|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureIllustration|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureIllustration[]    findAll()
 * @method PictureIllustration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureIllustrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictureIllustration::class);
    }

    // /**
    //  * @return PictureIllustration[] Returns an array of PictureIllustration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PictureIllustration
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
