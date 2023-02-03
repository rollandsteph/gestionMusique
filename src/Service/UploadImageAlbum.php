<?php

namespace App\Service;

use App\Service\UploadFichierInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadImageAlbum implements UploadFichierInterface
{
    private $repertoireDestination;
    public function __construct(String $repertoireDestination){
        $this->repertoireDestination=$repertoireDestination;
    }
    /**
     * upload une image dans le dossier de destination et retourne son nom ou null
     *
     * @param UploadedFile $fichier à uploder
     * @param String $nomImageActuelle
     * @return String|null retourne le nouveau nom de l'image ou null
     */
    public function enregistreImage(UploadedFile $fichier, String $nomImageActuelle){
         //on récupére l'image sélectionnée
         if($fichier != null){
             // on supprime l'ancien fichier
             if($nomImageActuelle !="pochettevierge.png"){
                 \unlink($this->repertoireDestination.$nomImageActuelle);
             }
             // On cree le nom du nouveau fichier
             $NouveauNomfichier=md5(\uniqid()).".".$fichier->guessExtension();
             // on déplace le fichier chargé dans le dossier public
             $fichier->move($this->repertoireDestination,$NouveauNomfichier);
             return $NouveauNomfichier;
         }else {
            return null;
         }
    }
}