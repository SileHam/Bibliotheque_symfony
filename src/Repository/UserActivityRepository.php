<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserActivity>
 *
 * @method UserActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserActivity[]    findAll()
 * @method UserActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserActivity::class);
    }

    public function findRecentForUser(User $user, int $limit = 10): array
    {
        return $this->createQueryBuilder('activity')
            ->andWhere('activity.user = :user')
            ->setParameter('user', $user)
            ->orderBy('activity.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findRecentGlobal(int $limit = 10): array
    {
        return $this->createQueryBuilder('activity')
            ->leftJoin('activity.user', 'user')
            ->addSelect('user')
            ->orderBy('activity.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
