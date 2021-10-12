<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use App\Repository\ParticipationRepository;
use App\Repository\SpotRepository;
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
     * @Route("/{id}/delete", name="backoffice_user_delete", methods={"GET","DELETE"}),requirements={"id": "\d+"})
     */
    public function delete(
        int $id,
        UserRepository $userRepository,
        EventRepository $eventRepository,
        SpotRepository $spotRepository,
        ParticipationRepository $participationRepository,
        CommentRepository $commentRepository
    ): Response
    {
        // A user is retrieved according to its id
        $user = $userRepository->find($id);
        // retrieve the anonymous user intended for the id replacement
        $userReplace = $userRepository->find(4);
 
        // check for "edit" access: calls all voters
        $this->denyAccessUnlessGranted('USER_DELETE', $user, "Vous n'avez pas accés à cette page' !");
        // If the user does not exist, we return a 404 error
        if (!$user) {
            return $this->json([
                'error' => 'L\'utilisateur ' . $id . ' n\'existe pas'
            ], 404);
        }
        // we get the id of the user
        $userId=$user->getId();

        // ---ParticipationRepository--
        // the Participation entity is recovered in the form of a table
        $entityParticipation = $participationRepository->findBy(array('user'=>$userId));
        // we get the participations linked to the user to validate the deletion if it exists
        $userParticipation=$user->getParticipations();

        // ---CommentRepository--
        // the Comment entity is recovered in the form of a table
        $entityComment = $commentRepository->findBy(array('user'=>$userId));
        // we get the Comments linked to the user to validate the deletion if it exists
        $userComment=$user->getComment();

        // ---EventRepository--
        // the Event entity is recovered in the form of a table
        $entityEvent = $eventRepository->findBy(array('author'=>$userId));
        // we get the Events linked to the user to validate the deletion if it exists
        $userEvent=$user->getEvents();

        // ---SpotRepository--
        // the Spot entity is recovered in the form of a table
        $entitySpot = $spotRepository->findBy(array('author'=>$userId));
        // we get the Spots linked to the user to validate the deletion if it exists
        $userSpot=$user->getSpots();
       
        if ($user!==null) {
            // We call the manager to manage the deletion
            $em = $this->getDoctrine()->getManager();

            if ($userParticipation!==null) {
                // If we have any participations related to this event, we delete them
                foreach ($entityParticipation as $idParticipation) {
                    $em->remove($idParticipation);
                }
                $em->flush();
            }
            if ($userComment!==null) {
                // If comments are created by the user we replace his id by the id of an anonymous user
                foreach ($entityComment as $idComment) {
                    $authorReplace=$idComment->setUser($userReplace);
                    $em->persist($authorReplace);
                }
                $em->flush();
            }
            if ($userEvent!==null) {
                // If events are created by the user we replace his id by the id of an anonymous user
                foreach ($entityEvent as $idEvent) {
                    $authorReplace=$idEvent->setAuthor($userReplace);
                    $em->persist($authorReplace);
                }
                $em->flush();
            }
            if ($userSpot!==null) {
                // If spots are created by the user we replace his id by the id of an anonymous user
                foreach ($entitySpot as $idSpot) {
                    $authorReplace=$idSpot->setAuthor($userReplace);
                    $em->persist($authorReplace);
                }
                $em->flush();
            }
            $em->remove($user);
        
            $em->flush(); // A DELETE SQL query is performed
            // Flash Message
            $this->addFlash('info', 'L utilisateur ' . $user->getPseudo() . ' a bien été supprimé');
        

            return $this->redirectToRoute('backoffice_user_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}