<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\ORM\Query;
use App\Model\FiltreAlbum;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @return Query Returns an array of Album objects
     */
    
    public function listeAlbumsCompletePaginee(FiltreAlbum $filtre=null): ?Query
    {
        // dd($filtre);
        $query= $this->createQueryBuilder('a')
            ->select('a','s','art','m')
            ->leftJoin('a.styles', 's')
            ->leftJoin('a.artiste','art')
            ->leftJoin('a.morceaux','m')
            ->orderBy('a.nom', 'ASC');
            if(!empty($filtre->nom)){
                $query->andWhere('a.nom like :nomcherche')
                ->setParameter('nomcherche', "%{$filtre->nom}%");
            }
            if(!empty($filtre->artiste)){
                $query->andWhere('a.artiste = :artistecherche')
                ->setParameter('artistecherche', $filtre->artiste);
            }
            // if(!empty($filtre->styles)){
            //     foreach ($filtre->styles as $key => $style) {
            //         $query->andWhere(":styleRecherche$key MEMBER OF a.styles")
            //         ->setParameter("styleRecherche$key", $style);      
            //     }
            // }
            if(!empty($filtre->styles) && $filtre->styles->count()>0){
                $conditions=[];
                foreach ($filtre->styles as $key => $style) {
                    $conditions[]= $query->expr()->isMemberOf(":styleRecherche$key","a.styles");
                    $query->setParameter("styleRecherche$key", $style);      
                }
                $blocConditionsOr=$query->expr()->orX()->addMultiple($conditions);
                $query->andWhere($blocConditionsOr);
            }
        ;
        return $query->getQuery();
    }


    /*
    public function findOneBySomeField($value): ?Album
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
