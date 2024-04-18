<?php

namespace App\Repository;

use App\Entity\CategorieMembre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieMembre>
 *
 * @method CategorieMembre|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieMembre|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieMembre[]    findAll()
 * @method CategorieMembre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieMembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieMembre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CategorieMembre $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CategorieMembre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return CategorieMembre[] Returns an array of CategorieMembre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieMembre
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
