<?php

namespace App\Controller\Backoffice;

use App\Entity\Spot;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /** 
    * @Route("/backoffice/spots", name="backoffice_")
    */
class SpotsController extends AbstractController
{
    // ===================== Page spots Display  =================//
    /**
     * @Route("/", name="spots", methods={"GET"})
     */
    public function index(SpotRepository $spotRepository): Response
    {
        $spotsShow = $spotRepository->findAll();

        return $this->render('backoffice/spots/index.html.twig', [
            'spots' => $spotsShow,
        ]);
    }

    // ===================== Page spot Display by id  =================//
    /**
    * @Route("/{id}", name="spot_show",  methods={"GET"})
    */
    public function show(Spot $spot): Response
    {
        return $this->render('backoffice/spots/show.html.twig', [
        'spot' => $spot,
        ]);
    }
}
