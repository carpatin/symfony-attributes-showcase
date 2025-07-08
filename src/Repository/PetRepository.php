<?php

namespace App\Repository;

use App\Entity\PetYourPet\Pet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Pet>
 */
class PetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pet::class);
    }

    public function findByName(?string $name): Pagerfanta
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC');

        if ($name !== null) {
            $qb
                ->andWhere('p.name LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }

        $qa = new QueryAdapter($qb);

        return new Pagerfanta($qa);
    }
}
