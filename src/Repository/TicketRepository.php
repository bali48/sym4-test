<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Entity\Department;
use App\Entity\Status;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    // /**
    //  * @return Ticket[] Returns an array of Ticket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllTicketsByUserID($UserID){
//        dump($UserID); exit;
                $query =  $this->createQueryBuilder('ticket')
//                ->select('ticket.id, ticket.title, user.name as username')
                ->addSelect('department')
                ->addSelect('user')
                ->addSelect('status')
                ->innerJoin('ticket.Department','department')
                ->innerJoin('ticket.userid','user')
                ->innerJoin('ticket.statusid','status')
//                ->where('ticket.userid = :userid')
//                ->setParameter('userid ', $UserID )
                ->getQuery()
                ->getResult();
                return $query;
        dump($query); exit;
    }
}
