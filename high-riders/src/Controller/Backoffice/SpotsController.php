<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotsController extends AbstractController
{
    /**
     * @Route("/backoffice/spots", name="backoffice_spots")
     */
    public function index(): Response
    {
        return $this->render('backoffice/spots/index.html.twig', [
            'controller_name' => 'spotsController',
        ]);
    }
}
