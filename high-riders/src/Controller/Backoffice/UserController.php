<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/backoffice/users", name="backoffice_")
     */
class UserController extends AbstractController
{
    // ===================== Page Users Display  =================//
    /**
    * @Route("/", name="user_index",  methods={"GET"})
    */
    public function index(UserRepository $userRepository): Response
    {
        $usershow = $userRepository->findAll();

        return $this->render('backoffice/user/index.html.twig', [
            'users' => $usershow,
        ]);
    }

    // ===================== Page User Display by id  =================//
    /**
    * @Route("/{id}", name="user_show",  methods={"GET"})
    */
    public function show(User $user): Response
    {
        return $this->render('backoffice/user/show.html.twig', [
        'user' => $user,
        ]);
    }


    
}
