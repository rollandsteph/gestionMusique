<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadFichierInterface{
    /**
     * upload une image dans le dossier de destination et retourne son nom ou null
     *
     * @param UploadedFile $fichier à uploder
     * @param String $nomImageActuelle
     * @return String|null retourne le nouveau nom de l'image ou null
     */
    public function enregistreImage(UploadedFile $fichier, String $nomImageActuelle);
}