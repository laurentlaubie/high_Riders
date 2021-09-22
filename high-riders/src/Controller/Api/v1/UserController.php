<?php

namespace App\Controller\Api\v1;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @Route("/api/v1/users", name="api_v1_user_", methods={"GET"})
 */
class UserController extends AbstractController
{
    /**
     * Display all spots
     * 
     * URL : /api/v1/users/
     * Road : api_v1_user_index
     * 
     * 
     * @Route("/", name="index")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->json($users, 200, [], [
            'groups' => ['index_user']
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function show(User $user): Response
    {
         // If the user does not exist, we return a 404 error
         if (!$user) {
            return $this->json([
                'error' => 'L\'utilisateur n\'existe pas'
            ], 404);
        }
        return $this->json($user, 200, [], [
            'groups' => ['show_user']
        ]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);

        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);

        if ($form->isValid()) {
            $password = $form->get('password')->getData();
            $confirmedPassword = $form->get('confirmedPassword')->getData();

            if ($password === $confirmedPassword) {
                $user->setPassword($passwordEncoder->hashPassword($user, $password));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->json($user, 201, [], [
                    'groups' => ['add_user'],
                ]);
            }
        }

        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }


    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"}, requirements={"id": "\d+"})
     */
    public function edit(User $user, Request $request, UserPasswordHasher $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('USER', $user, "Vous n'avez pas accés à cette page' !");

        $form = $this->createForm(UserEditType::class, $user, ['csrf_protection' => false]);

        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);



        if ($form->isValid()) {
            
            $password = $form->get('password')->getData();


            if ($password !== null) {
                $confirmedPassword = $form->get('confirmedPassword')->getData();
                if ($password === $confirmedPassword) {
                    $user->setPassword($passwordEncoder->hashPassword($user, $confirmedPassword));
                } else {
                    return $this->json('the 2 passwords are differents', 404);
                }
            }
            $user->setUpdatedAt(new \DateTimeImmutable());
            $this->getDoctrine()->getManager()->flush();

            return $this->json($user, 200, [], [
                'groups' => ['edit_user'],
            ]);
        }
        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function delete(User $user, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }


        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->json(['l\'utilisateur à été suprimer'], 204);
    }

}
