<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Entity\Spot;
use App\Form\EventsType;
use App\Repository\EventRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
     * @Route("/backoffice/events", name="backoffice_", requirements={"id":"\d+"} )
     */
class EventsController extends AbstractController
{
    // ===================== Page Events Display  =================//
    /**
     * @Route("/", name="events", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $eventsShow = $eventRepository->findAll();

        return $this->render('backoffice/events/index.html.twig', [
            'events' => $eventsShow,
        ]);
    }

    // ===================== Page Event Display by id  =================//
    /**
    * @Route("/{id}", name="_events_show", methods={"GET"})
    */
    public function show(Event $event): Response
    {
        return $this->render('backoffice/events/show.html.twig', [
            'event'=> $event,
        ]);
    }

    // ===================== Page add Event  =================//
    /**
    * @Route("/add", name="event_add", methods={"GET","POST"}, priority=2)
    */
    public function add(Request $request, ImageUploader $imageUploader, SluggerInterface $slugger): Response
    {
        $event = new Event();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /* $imageFile = $imageUploader->upload($form, 'image');
            dd($imageFile);
            if ($imageFile) {
                $spot->setImage($imageFile);
            } */
           
            //recovery the spot's title
            $title = $event->getTitle();

            // transform in slug
            $slug = $slugger->slug(strtolower($title));

            // update the entity
            $event->setSlug($slug);
            //  dd($event);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // Flash Message
            $this->addFlash('success', 'L\'event ' . $event->getTitle() . ' a bien été ajouté');

            return $this->redirectToRoute('backoffice_events', [], Response::HTTP_SEE_OTHER);
        }
            return $this->renderForm('backoffice/events/add.html.twig', [
                'event' => $event,
                'form' => $form,
            ]);
    }

    // ===================== Delete a event  =================//
    /**
    * @Route("/{id}/delete", name="event_delete" )
    *
    */
    public function delete(Event $event): Response
    {
        // delete an Event in Bdd
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
            
        // Flash Message
        $this->addFlash('info', 'l\'Evenement ' . $event->getTitle() . ' a bien été supprimé');

        return $this->redirectToRoute('backoffice_events');
    }


}