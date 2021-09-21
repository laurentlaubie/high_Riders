<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/api/v1/events", name="api_v1_events")
     */
    public function index(): Response
    {
        return $this->render('api/v1/events/index.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }
}
