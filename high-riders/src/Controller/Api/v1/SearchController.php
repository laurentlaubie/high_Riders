<?php

namespace App\Controller\Api\v1;

use App\Repository\EventRepository;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/api/v1/search", name="api_v1_search", methods={"GET"})
     */
    public function index(Request $request, SpotRepository $spotRepository, EventRepository $eventRepository): Response
    {
        $query = $request->query->get('search');
        // We retrieve the series stored in BDD
        // data recovery from the entiy spot whith findBy by selection orderBy and limit the last 3 register.
        $spotsResult = $spotRepository->searchSpotByTitle($query);
        // data recovery from the entiy event whith findBy by selection orderBy and limit the last 3 register.
        $eventsResult = $eventRepository->searchEventByTitle($query);
       

        return $this->json( [ $spotsResult, $eventsResult], 200, [],[
            // This input to the Serialiser to transform the objects
            // objects into JSON, fetching only the properties
            // tagged with the name event_list
            'groups' => ['event_list','spot_list']
            
        ]);
    }
}
