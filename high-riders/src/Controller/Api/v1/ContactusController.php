<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactusController extends AbstractController
{
    /**
     * @Route("/api/v1/contactus", name="api_v1_contactus")
     */
    public function index(): Response
    {
        return $this->render('api/v1/contactus/index.html.twig', [
            'controller_name' => 'ContactusController',
        ]);
    }
}
