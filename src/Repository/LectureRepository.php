<?php

namespace App\Repository;

use App\Entity\Lecture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lecture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecture[]    findAll()
 * @method Lecture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LectureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lecture::class);
    }

    /**
     * @return Lecture[] Returns an array of Lecture objects
     */

    public function filter($course, $teacher)
    {
        if($teacher != null){
            return $this->findBy(['course' => $course, 'teacher' => $teacher]);
        }
        return $this->findBy(['course' => $course]);
    }



    /*
    public function findOneBySomeField($value): ?Lecture
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
