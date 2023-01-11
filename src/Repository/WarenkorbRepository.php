<?php

namespace App\Repository;

use App\Entity\Warenkorb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Warenkorb>
 *
 * @method Warenkorb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Warenkorb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Warenkorb[]    findAll()
 * @method Warenkorb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarenkorbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warenkorb::class);
    }

    public function add(Warenkorb $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Warenkorb $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByArtikelID($artikelID = 0, $email){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM warenkorb w
            WHERE w.artikel_id = :artikelID
                AND w.email = :email
            ';
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['artikelID' => $artikelID, 'email' => $email]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findAllByEmail($email){
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.email = :email')
//            ->setParameter('email', $email)
//            ->getQuery()
//            ->getArrayResult()
//        ;
        $conn = $this->getEntityManager()->getConnection();

//        $sql = '
//            SELECT artikel_id, artikelname, epreis, email, count(anzahl) as anzahl FROM warenkorb w
//            WHERE w.email = :email
//            group by artikel_id
//            ';
        $sql = '
            SELECT * FROM warenkorb w
            WHERE w.email = :email
            ';
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery(['email' => $email]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    //select artikel_id, artikelname, epreis, email, count(anzahl) as anzahl from warenkorb group by artikel_id;

//    /**
//     * @return Warenkorb[] Returns an array of Warenkorb objects
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

//    public function findOneBySomeField($value): ?Warenkorb
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
