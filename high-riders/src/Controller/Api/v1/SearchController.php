<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/api/v1/search", name="api_v1_search")
     */
    public function index(): Response
    {
        return $this->render('api/v1/search/index.html.twig', [
            'controller_name' => 'searchController',
        ]);
    }
}
