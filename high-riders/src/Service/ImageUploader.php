<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($form, string $fieldName)
    {
        /** @var UploadedFile $imgFile */
        $imgFile = $form->get($fieldName)->getData();

        if ($imgFile) {
            // On récupère le nom du fichier
            $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);

            // Pour des raisons de sécurité, on va nettoyer le nom du fichier
            // grâce à la méthode slug du Service SluggerInterface
            $safeFilename = $this->slugger->slug($originalFilename);

            // Pour éviter que 2 utilisateurs upload 2 fichiers avec des noms identiques
            // et pour ne pas écraser le fichier d'une autre personne
            // on va renommer nos fichiers en rajoutant un suffix composé
            // de caractères aléatoires et unique.
            // Chuch_Norris-4141544.jpg
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();

            try {
                // On déplace le fichier dans le dossier public/uploads
                $imgFile->move('uploads', $newFilename);

                // on retourne le nom du fichier
                return $newFilename;
            } catch (FileException $e) {
                // Si ça se passe mal...on envoie un email à l'admin
            }

            return false;
        }
    }
}
