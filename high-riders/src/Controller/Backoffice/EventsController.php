<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Entity\Spot;
use App\Form\EventsType;
use App\Repository\EventRepository;
use App\Repository\ParticipationRepository;
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
    * @Route("/{id}", name="events_show", methods={"GET"})
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

            $imageFile = $imageUploader->upload($form, 'image');
           
            if ($imageFile) {
                $event->setImage($imageFile);
            }
           
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

     // ===================== Page edit an Event  =================//
    /**
    * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
    */
    public function edit(Request $request, Event $event, SluggerInterface $slugger, ImageUploader $imageUploader ): Response
    {
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $imageUploader->upload($form, 'image');
            
             if ($imageFile) {
                 $event->setImage($imageFile);
            }

            // recovery the Event's title
            $title = $event->getTitle();

            // transform in slug
            $slug = $slugger->slug(strtolower($title));

            // update the entity
            $event->setSlug($slug);

            //$imageFile = $imageUploader->upload($form, 'imgupload');
            //if ($imageFile) {
            //    $event->setImage($imageFile);
            //}

            $this->getDoctrine()->getManager()->flush();

            // Flash Message
           $this->addFlash('success', 'L\'Evenement ' . $event->getTitle() . ' a bien été modifié');

            return $this->redirectToRoute('backoffice_events', [], Response::HTTP_SEE_OTHER);
        }
            return $this->renderForm('backoffice/events/edit.html.twig', [
                'event' => $event,
                'form' => $form,
            ]);

   }



    // ===================== Delete a event  =================//
    /**
    * @Route("/{id}/delete", name="event_delete" )
    *
    */
    public function delete(int $id, EventRepository $eventRepository, ParticipationRepository $participation): Response
    {

         // A event is retrieved according to its id
         $event = $eventRepository->find($id);
        
          // check for "delete" access: calls all voters
        $this->denyAccessUnlessGranted('EVENT_DELETE', $event);

        $eventId=$event->getId();
        $entityParticipation = $participation->findBy(array('event'=>$eventId));
        $eventParticipation=$event->getParticipations();
       
        if ($event!==null) {
            // We call the manager to manage the deletion
            $em = $this->getDoctrine()->getManager();

            if ($eventParticipation!==null) {
               
                foreach ($entityParticipation as $idParticipation) {
                    $em->remove($idParticipation);
                }
                $em->flush();
            }
            $em->remove($event);
        
            $em->flush(); // A DELETE SQL query is performed

            // Flash Message
            $this->addFlash('info', 'l\'Evenement ' . $event->getTitle() . ' a bien été supprimé');
    
            return $this->redirectToRoute('backoffice_events');
           
        }
       
    }


}