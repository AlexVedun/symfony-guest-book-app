<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wish>
 *
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public const ITEMS_PER_PAGE = 25;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function getWishPaginator(int $page, int $userId = null): Paginator
    {
        $andX = new Andx();
        $orX = new Orx();

        $queryBuilder = $this->createQueryBuilder('w');

        $andX->add($queryBuilder->expr()->eq('w.isModerated', 'TRUE'));

        if ($userId) {
            $orX->add($queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq('w.isModerated', 'FALSE'),
                $queryBuilder->expr()->eq('w.user', ':userId')
            ));
            $queryBuilder->setParameter('userId', $userId);
        }

        $orX->add($andX);

        $query = $queryBuilder
            ->andWhere($orX)
            ->orderBy('w.createdAt', 'desc')
            ->setMaxResults(self::ITEMS_PER_PAGE)
            ->setFirstResult(($page - 1) * self::ITEMS_PER_PAGE)
            ->getQuery();

        return new Paginator($query);
    }

//    /**
//     * @return Wish[] Returns an array of Wish objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Wish
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
