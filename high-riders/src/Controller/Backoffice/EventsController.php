<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/backoffice/events", name="backoffice_events")
     */
    public function index(): Response
    {
        return $this->render('backoffice/events/index.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }
}
