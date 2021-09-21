<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/v1/user", name="api_v1_user")
     */
    public function index(): Response
    {
        return $this->render('api/v1/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
