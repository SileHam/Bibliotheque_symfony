<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class LivreRepository extends ServiceEntityRepository
{
    public const PER_PAGE = 6;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Livre[]
     */
    public function findPaginatedCatalog(int $page, ?string $searchTerm = null): array
    {
        return $this->createCatalogQueryBuilder($searchTerm)
            ->setFirstResult((max(1, $page) - 1) * self::PER_PAGE)
            ->setMaxResults(self::PER_PAGE)
            ->getQuery()
            ->getResult();
    }

    public function countCatalog(?string $searchTerm = null): int
    {
        return (int) $this->createCatalogQueryBuilder($searchTerm)
            ->select('COUNT(DISTINCT l.id)')
            ->resetDQLPart('orderBy')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Livre[]
     */
    public function findFeatured(int $limit = 6): array
    {
        return $this->createQueryBuilder('l')
            ->addSelect('auteur', 'genre')
            ->leftJoin('l.auteurs', 'auteur')
            ->leftJoin('l.genres', 'genre')
            ->orderBy('l.note', 'DESC')
            ->addOrderBy('l.date_de_parution', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    private function createCatalogQueryBuilder(?string $searchTerm = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('l')
            ->addSelect('auteur', 'genre')
            ->leftJoin('l.auteurs', 'auteur')
            ->leftJoin('l.genres', 'genre')
            ->orderBy('l.date_de_parution', 'DESC')
            ->addOrderBy('l.titre', 'ASC');

        if ($searchTerm !== null && $searchTerm !== '') {
            $qb
                ->andWhere('l.titre LIKE :term OR l.description LIKE :term')
                ->setParameter('term', '%'.$searchTerm.'%');
        }

        return $qb;
    }
}
