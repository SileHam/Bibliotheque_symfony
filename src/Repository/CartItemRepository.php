<?php

namespace App\Repository;

use App\Entity\CartItem;
use App\Entity\Livre;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CartItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function findOneForUserAndBook(User $user, Livre $livre): ?CartItem
    {
        return $this->createQueryBuilder('cartItem')
            ->andWhere('cartItem.user = :user')
            ->andWhere('cartItem.livre = :livre')
            ->setParameter('user', $user)
            ->setParameter('livre', $livre)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return CartItem[]
     */
    public function findDetailedCartForUser(User $user): array
    {
        return $this->createQueryBuilder('cartItem')
            ->addSelect('livre', 'auteur', 'genre')
            ->join('cartItem.livre', 'livre')
            ->leftJoin('livre.auteurs', 'auteur')
            ->leftJoin('livre.genres', 'genre')
            ->andWhere('cartItem.user = :user')
            ->setParameter('user', $user)
            ->orderBy('cartItem.updatedAt', 'DESC')
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    public function countQuantityForUser(User $user): int
    {
        return (int) $this->createQueryBuilder('cartItem')
            ->select('COALESCE(SUM(cartItem.quantity), 0)')
            ->andWhere('cartItem.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
