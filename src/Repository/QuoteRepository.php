<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quote>
 */
class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function findRandom(): ?Quote
    {
        $total = $this
            ->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // pick one random offset then retrieve quote at offset
        $offset = random_int(0, $total - 1);

        return $this
            ->createQueryBuilder('q')
            ->select('q', 'a') // make author be eager loaded
            ->leftJoin('q.author', 'a') // make author be eager loaded
            ->setFirstResult($offset)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findRandomHighlyLiked(): ?Quote
    {
        $maxDql = $this
            ->createQueryBuilder('q_max')
            ->select('MAX(q_max.likes)')
            ->getDQL();

        $qb = $this->createQueryBuilder('q');
        $ids = $qb
            ->select('q.id')
            ->andWhere($qb->expr()->eq('q.likes', '('.$maxDql.')'))
            ->getQuery()
            ->getSingleColumnResult();

        if (empty($ids)) {
            return null;
        }

        $id = $ids[array_rand($ids)];
        $qb = $this->createQueryBuilder('q');

        return $qb
            ->andWhere($qb->expr()->eq('q.id', ':id'))
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
