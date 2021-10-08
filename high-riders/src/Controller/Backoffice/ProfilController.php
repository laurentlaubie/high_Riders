<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /** 
     * @Route("/backoffice/profil", name="backoffice_profil_")
     */
class ProfilController extends AbstractController
{

    /**
     * @Route("/{id}", name="index", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('backoffice/profil/index.html.twig', [
            'user' => $user,
        ]);
    }
}
