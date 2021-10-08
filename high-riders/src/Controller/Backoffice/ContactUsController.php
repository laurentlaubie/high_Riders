<?php

namespace App\Controller\Backoffice;

use App\Repository\ContactusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/backoffice/contact/us", name="backoffice_")
     */
class ContactUsController extends AbstractController
{
    // ===================== Page contact Display  =================//
    /**
     * @Route("/", name="contact", methods={"GET"})
     */
    public function index(ContactusRepository $contactusRepository): Response
    {
        $contactUS = $contactusRepository->findAll();

        return $this->render('backoffice/contact_us/index.html.twig', [
            'ContactUs' => $contactUS,
        ]);
    }
}
