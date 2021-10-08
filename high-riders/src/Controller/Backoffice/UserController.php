<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/backoffice/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="backoffice_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backoffice/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/add", name="backoffice_user_add", methods={"GET","POST"})
     */
    public function add(Request $request, UserPasswordHasherInterface $passwordHasher, ImageUploader $imageUploader, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $imageUploader->upload($form, 'avatar');
            //dd($imageFile);
            if ($imageFile) {
                $user->setAvatar($imageFile);
           }
           /* // recovery the avatar's pseudo
           $title = $user->getPseudo();

           // transform in slug
           $slug = $slugger->slug(strtolower($title));

           // update the entity
           $user->setSlug($slug); */


            // A la création d'un utilisateur
            // on va hasher le mot de passe saisi en clair
            // dans le formulaire
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('backoffice_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/user/add.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="backoffice_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('backoffice/user/show.html.twig', [
            'user' => $user,
        ]);
    }

     // ===================== Page edit an User  =================//
    /**
     * @Route("/{id}/edit", name="backoffice_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, ImageUploader $imageUploader): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $imageUploader->upload($form, 'avatar');
            //dd($imageFile);
            if ($imageFile) {
                $user->setAvatar($imageFile);
           }

            $this->getDoctrine()->getManager()->flush();

             // Flash Message
             $this->addFlash('success', 'L\'utilisateur'  . $user->getPseudo() . ' a bien été modifié');

            return $this->redirectToRoute('backoffice_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="backoffice_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backoffice_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
