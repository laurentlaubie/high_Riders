<?php

namespace App\Controller\Api\v1;

use App\Repository\EventRepository;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/api/v1/home", name="api_v1_home", methods={"GET"})
     */
    public function index(SpotRepository $spotRepository, EventRepository $eventRepository): Response
    {
        // We retrieve the series stored in BDD
        // data recovery from the entiy spot whith findBy by selection orderBy and limit the last 3 register.
        $lastSpots = $spotRepository->findBy([],['id' => 'DESC'], 3);
        // data recovery from the entiy event whith findBy by selection orderBy and limit the last 3 register.
        $lastEvents = $eventRepository->findBy([],['id' => 'DESC'], 3);
        // data recovery from the entiy spot whith findBy by selection orderBy and limit 3 best like register.
        $bestSpots = $spotRepository->findBy([],['s_like' => 'DESC'], 3);

        return $this->json( [ $lastSpots, $lastEvents, $bestSpots ], 200, [],[
            // This input to the Serialiser to transform the objects
            // objects into JSON, fetching only the properties
            // tagged with the name event_list
            'groups' => ['api_home']
            
        ]);
    }
}
