<?php

namespace App\Controller\Api\v1;

use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpotsController extends AbstractController
{
    /**
     * @Route("/api/v1/spots", name="api_v1_spots")
     */
    public function index(SpotRepository $spotRepository): Response
    {
        $spots =$spotRepository->findAll();

        return $this->json($spots, 200, [
            'controller_name' => 'SpotsController',
        ]);
    }
}
