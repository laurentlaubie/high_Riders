<?php

namespace App\Controller\Backoffice;

use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/backoffice", name="backoffice_")
     */
class homeController extends AbstractController
{
    // =====================affiche page d accueil =================//
    /**
     * @Route("/home", name="home")
     */
    public function index( SpotRepository $spotRepository): Response
    {
        $spotshow = $spotRepository->findAll();

        return $this->render('backoffice/home/index.html.twig', [
           
            'spots' => $spotshow,

        ]);
    }
}
