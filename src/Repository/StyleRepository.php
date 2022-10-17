<?php

namespace App\Repository;

use App\Entity\Style;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Style|null find($id, $lockMode = null, $lockVersion = null)
 * @method Style|null findOneBy(array $criteria, array $orderBy = null)
 * @method Style[]    findAll()
 * @method Style[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Style::class);
    }
    /**
     * @return Query Returns an array of Artiste objects
     */
    
    public function listeStylesCompletePaginee():Query
    {
        return $this->createQueryBuilder('s')
            ->select('s','alb')
            ->leftJoin('s.albums','alb')
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
        ;
    }
}
