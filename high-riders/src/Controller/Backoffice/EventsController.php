<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/backoffice/events", name="backoffice_")
     */
class EventsController extends AbstractController
{
    // ===================== Page Events Display  =================//
    /**
     * @Route("/", name="_events", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $eventsShow = $eventRepository->findAll();

        return $this->render('backoffice/events/index.html.twig', [
            'events' => $eventsShow,
        ]);
    }

    // ===================== Page Event Display by id  =================//
    /**
    * @Route("/{id}", name="_events_show", methods={"GET"})
    */
    public function show(Event $event): Response
    {
        return $this->render('backoffice/events/show.html.twig', [
            'event'=> $event,
        ]);
    }



}