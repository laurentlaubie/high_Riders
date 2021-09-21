<?php

namespace App\Controller\Backoffice;

use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/backoffice", name="backoffice_")
     */
class HomeController extends AbstractController
{
    // ===================== home page display =================//
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
       
        return $this->render('backoffice/index.html.twig', [
            'home' => 'BackofficeController',

        ]);
    }
}
