<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlbumController extends AbstractController
{
    /**
     * @Route("/albums", name="albums", methods={"GET"})
     */
    public function listealbums(AlbumRepository $repo)
    {
        $albums = $repo->findAll();
        return $this->render('album/listeAlbums.html.twig', [
            'lesAlbums' => $albums
        ]);
    }

    /**
     * @Route("/album/{id}", name="ficheAlbum", methods={"GET"})
     */
    public function fichealbum(Album $album)
    {
        return $this->render('album/ficheAlbum.html.twig', [
            'leAlbum' => $album
        ]);
    }

}
