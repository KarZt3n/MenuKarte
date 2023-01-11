<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function add(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllBySlug($slug){
        return $this->createQueryBuilder('n')
            ->andWhere('n.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findLastCreateAt($dateTime) :array{
        return $this->createQueryBuilder('n')
            ->Where('n.createAt <= :createAt')
            ->andWhere('n.isEvent = 0')
            ->andWhere('n.hide = 0')
            ->andWhere('n.deleted = 0')
            ->setParameter('createAt', date_format($dateTime, 'Y-m-d H:i:s'))
            ->orderBy('n.createAt', 'DESC')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function findAllEventsInFuture($dateTime) :array{
        return $this->createQueryBuilder('n')
            ->andWhere('n.eventStart >= :eventStart and n.isEvent = 1 and n.hide = 0 and n.deleted = 0')
            ->setParameter('eventStart', date_format($dateTime, 'Y-m-d H:i:s'))
            ->orderBy('n.eventStart', 'ASC')
            ->getQuery()
            ->getArrayResult()
            ;
    }

//    /**
//     * @return News[] Returns an array of News objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?News
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
