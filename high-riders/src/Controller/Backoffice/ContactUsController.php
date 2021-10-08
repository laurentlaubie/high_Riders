<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/backoffice/contact/us", name="backoffice_contact_us")
     */
    public function index(): Response
    {
        return $this->render('backoffice/contact_us/index.html.twig', [
            'controller_name' => 'ContactUsController',
        ]);
    }
}
