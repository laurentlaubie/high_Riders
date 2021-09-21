<?php

namespace App\Controller\Api\v1;

use App\Repository\EventRepository;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/api/v1", name="api_v1_")
     */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SpotRepository $spotRepository, EventRepository $eventRepository): Response
    {
        // $eventdd = $eventRepository->findAll();
        // dd($eventdd);
        return $this->render('api/v1/home/index.html.twig', [
            
          
            'lastSpots' => $spotRepository->findBy([],['id' => 'DESC'], 3),
            
            'lastEvents' => $eventRepository->findBy([],['id' => 'DESC'], 3),
            'bestSpots' => $spotRepository->findBy([],['s_like' => 'DESC'], 3),
        ]);
    }
}
