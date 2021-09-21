<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotsController extends AbstractController
{
    /**
     * @Route("/api/v1/spots", name="api_v1_spots")
     */
    public function index(): Response
    {
        return $this->render('api/v1/spots/index.html.twig', [
            'controller_name' => 'SpotsController',
        ]);
    }
}
