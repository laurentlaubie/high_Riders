<?php

namespace App\Controller\Backoffice;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/backoffice", name="backoffice_")
     */
class userController extends AbstractController
{
    // ===================== affiche page user  =================//
    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $userRepository): Response
    {
        $usershow = $userRepository->findAll();

        return $this->render('backoffice/user/index.html.twig', [
            'users' => $usershow,
        ]);
    }
}
