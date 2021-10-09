<?php

namespace App\Controller\Api\v1;

use App\Entity\Comment;
use App\Entity\Event;
use App\Entity\Participation;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\DepartementRepository;
use App\Repository\EventRepository;
use App\Repository\ParticipationRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/events", name="api_v1_event_", methods={"GET"})
 */
class EventsController extends AbstractController
{
      /**
     * Display all events
     * 
     * URL : /api/v1/events/
     * Road : api_v1_event_index
     * 
     * @param mixed $name
     * @Route("/", name="index")
     */
    public function index(
        EventRepository $eventRepository, 
        CategoryRepository $categoryRepository, 
        DepartementRepository $departementRepository
        ): Response
    {
        // We retrieve the series stored in BDD
        $events =$eventRepository->findAll();
        $category = $categoryRepository->findAll();
        $departement = $departementRepository->findAll();

        // Return the list in JSON format
        // To solve the bug : Reference circular
        return $this->json([$events,$category,$departement], 200, [], [
            // This input to the Serialiser to transform the objects
            // objects into JSON, fetching only the properties
            // tagged with the name event_list
            'groups' => 'event_list',
            
        ]);
    }

      /**
     
     *
     * Displays the details of a event according to
     * its ID
     * 
     * URL : /api/v1/events/{id}
     * Road : api_v1_event_show
     * 
     * @Route("/{id}", name="_show", requirements={"id":"\d+"}, methods={"GET"})
     * 
     
     * @return JsonResponse
     */
    public function show(
        int $id, 
        eventRepository $eventRepository
        )
    {
        // A event is retrieved according to its id
        $event = $eventRepository->find($id);


        // If the event does not exist, we return a 404 error
        if (!$event) {
            return $this->json([
                'error' => 'Le event ' . $id . ' n\'existe pas'
            ], 404);
        }

       
        return $this->json($event, 200, [], [
            // Return the result in JSON format
            // tagged with the name event_detail
            'groups' => 'event_detail'
        ]);
    }

     /**
     * Allows the creation of a new event
     * 
     * URL : /api/v1/events/
     * 
     * @Route("/add", name="add", methods={"POST"})
     *
     * @return void
     */
    public function add(
        Request $request, 
        SerializerInterface $serialiser, 
        ValidatorInterface $validator, 
        SluggerInterface $sluggerInterface,
        UserService $service
        )
    {
         // We retrieve the JSON
         $jsonData = $request->getContent();

         //  We transform the json into an object : deserialization
         // - We indicate the data to transform (deserialize)
         // - We indicate the format of arrival after conversion (object of type event)
         // - We indicate the format of departure: we want to pass from json towards an object event
         $event = $serialiser->deserialize($jsonData, Event::class, 'json');
 
         // We validate the data stored in the $event object based on
         // on the critieria of the @Assert annotation of the entity (cf. src/Entity/event.php)
        
        // If the error array is not empty (at least 1 error)
        // count allows to count the number of elements of an array
        $errors = $validator->validate($event);

        if(count($errors) > 0){

            // Code 400 : bad request , the data received is not
            // not compliant
            return $this->json($errors, 400);
            
        }else{

            // add a User Id with UserService
            $user = $service->getCurrentUser();

            //recovery the spot's title
            $title = $event->getTitle();
            // transform in slug
            $slug = $sluggerInterface->slug(strtolower($title));
            // update the entity
            $event->setSlug($slug);

            $event->setAuthor($user);

            // To save, we call the manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            // A response is returned indicating that the resource
            // has been created (http code 201)
            return $this->json($event, 201, [], [
                'groups' => ['event_detail'],
            ]);
        }

    }

     /**
     * Allows the creation of a new event
     * 
     * URL : /api/v1/events/{id}/comment
     * Road : api_v1_event_addComment
     * 
     * @Route("/{id}/comment", name="addComment", requirements={"id":"\d+"}, methods={"POST"})
     *
     * @return void
     */
    public function addComment(
        Event $event, 
        Request $request, 
        SerializerInterface $serialiser, 
        ValidatorInterface $validator, 
        UserService $service)
    {
        // We retrieve the JSON
        $jsonData = $request->getContent();

        //  We transform the json into an object : deserialization
        // - We indicate the data to transform (deserialize)
        // - We indicate the format of arrival after conversion (object of type comment)
        // - We indicate the format of departure: we want to pass from json towards an object comment
        $comment = $serialiser->deserialize($jsonData, Comment::class, 'json');
    
        // We validate the data stored in the $comment object based on
        // on the critieria of the @Assert annotation of the entity (cf. src/Entity/comment.php)
         
        // If the error array is not empty (at least 1 error)
        // count allows to count the number of elements of an array
        // count([1, 2, 3]) ==> 3
        $errors = $validator->validate($comment);

        if(count($errors) > 0){

            // Code 400 : bad request , the data received is not
            // not compliant
            return $this->json($errors, 400);
            
        }else{
            // add a User Id with UserService
            $user = $service->getCurrentUser();

            // To inject the id of the current event in the participation table
            $event->getId();

            // update the entity
            $comment->setUser($user);
            $comment->setEvent($event);

            // To save, we call the manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            // A response is returned indicating that the resource
            // has been created (http code 201)
            return $this->json($comment, 201, [], [
                'groups' => ['event_detail'],
            ]);
        }

    }

    /**
     * Deleting a event based on its ID
     * 
     * URL : /api/v1/events/{id}/comment/{id}
     * Road : api_v1_event_removeComment
     * 
     * @Route("/{event}/comment/{id}", name="removeComment", requirements={"id":"\d+"}, methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function removeComment(
        int $id, 
        CommentRepository $commentRepository
        )
    {
        // A comment is retrieved according to its id
        $comment = $commentRepository->find($id);
       
        // check for "delete" access: calls all voters
        $this->denyAccessUnlessGranted('COMMENT_DELETE', $comment);

        // If the comment does not exist, we return a 404 error
        if (!$comment) {
            return $this->json([
                'error' => 'Le commentaire ' . $id . ' n\'existe pas'
            ], 404);
        }
 

        // We call the manager to manage the deletion
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush(); // A DELETE SQL query is performed

        return $this->json(['le commentaire avec l\'id '. $id . ' à été suprimer'], 203);
        
    }

     /**
     * Allows the creation of a new event to participation
     * 
     *  URL : /api/v1/events/{id}/participation
     * Road : api_v1_event_addParticipation
     * @Route("/{id}/participation", name="addParticipation", requirements={"id":"\d+"}, methods={"POST"})
     *
     * @return void
     */
    public function addParticipation(
        Event $event, 
        Request $request, 
        SerializerInterface $serialiser, 
        ValidatorInterface $validator, 
        UserService $service
        )
    {
        // We retrieve the JSON
        $jsonData = $request->getContent();

        //  We transform the json into an object : deserialization
        // - We indicate the data to transform (deserialize)
        // - We indicate the format of arrival after conversion (object of type Participation)
        // - We indicate the format of departure: we want to pass from json towards an object Participation
        $participation = $serialiser->deserialize($jsonData, Participation::class, 'json');
        
        // We validate the data stored in the $participation object based on
        // on the critieria of the @Assert annotation of the entity (cf. src/Entity/participation.php)
    
        // If the error array is not empty (at least 1 error)
        // count allows to count the number of elements of an array
        // count([1, 2, 3]) ==> 3
        $errors = $validator->validate($participation);

        if(count($errors) > 0){

            // Code 400 : bad request , the data received is not
            // not compliant
            return $this->json($errors, 400);
            
        }else{
            // add a User Id with UserService
            $user = $service->getCurrentUser();
             
            // To inject the id of the current event in the participation table
            $event->getId();
            // update the entity
            $participation->setUser($user);
            $participation->setEvent($event);

            // To count the number of participants, we count the number of entries in the 
            // Participation table and inject it into the ParticipationUser property

            $countParticipation=$event->getParticipations();
            $InjectionParticipapation = (count($countParticipation));
            
            $event->setParticipationUser($InjectionParticipapation);

            // To save, we call the manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->persist($event);
            $em->flush();

            // A response is returned indicating that the resource
            // has been created (http code 201)
            return $this->json($participation, 201, [], [
                'groups' => ['event_detail'],
            ]);
        }

    }

     /**
     * Allows the creation of a new event
     * 
     *  URL : /api/v1/events/{id}/like
     * Road : api_v1_event_addLike
     * @Route("/{id}/like", name="addLike", requirements={"id":"\d+"}, methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function addLike(
        int $id, 
        EventRepository $eventRepository, 
        Request $request, 
        SerializerInterface $serialiser 
        )
    {
        // A event is retrieved according to its id
        $event = $eventRepository->find($id);
        
        
        // If the event does not exist, we return a 404 error
        if (!$event) {
            return $this->json([
                'error' => 'La event ' . $id . ' n\'existe pas'
            ], 404);
        }


        // We retrieve the JSON
        $jsonData = $request->getContent();

        // We merge the data from the event with the data
        // from the Front application (insomnia, react, ...)
        // Deserializing in an Existing Object : https://symfony.com/doc/current/components/serializer.html#deserializing-in-an-existing-object
         $event = $serialiser->deserialize($jsonData, Event::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);
        
         $eventLike = $event->getSLike();
         $addLike =($eventLike + 1);

         $event->setSLike($addLike);
         // We call the manager to perform the update in DB
         $em = $this->getDoctrine()->getManager();
        
         $em->flush();
       
         return $this->json($event, 200, [], [
            'groups' => ['event_detail'],
        ]);
    }

     /**
     * Allows the creation of a new event
     * 
     *  URL : /api/v1/events/{id}/dislike
     * Road : api_v1_event_removeLike
     * @Route("/{id}/dislike", name="removeLike", requirements={"id":"\d+"}, methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function removeLike(
        int $id, 
        EventRepository $eventRepository, 
        Request $request, 
        SerializerInterface $serialiser
        )
    {
        // A event is retrieved according to its id
        $event = $eventRepository->find($id);
        
        
        // If the event does not exist, we return a 404 error
        if (!$event) {
            return $this->json([
                'error' => 'La event ' . $id . ' n\'existe pas'
            ], 404);
        }


        // We retrieve the JSON
        $jsonData = $request->getContent();

        // We merge the data from the event with the data
        // from the Front application (insomnia, react, ...)
        // Deserializing in an Existing Object : https://symfony.com/doc/current/components/serializer.html#deserializing-in-an-existing-object
         $event = $serialiser->deserialize($jsonData, Event::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);
        
         $eventLike = $event->getSLike();
         $addLike =($eventLike - 1);

         $event->setSLike($addLike);
         // We call the manager to perform the update in DB
         $em = $this->getDoctrine()->getManager();
        
         $em->flush();
       
         return $this->json($event, 200, [], [
            'groups' => ['event_detail'],
        ]);
    }

    /**
     
     *
     * Update of a event according to
     * its Identifier
     * 
     * URL : /api/v1/events/{id}
     * Road : api_v1_event_update
     * 
     * @Route("/{id}", name="update", requirements={"id":"\d+"}, methods={"PUT", "PATCH"})
     * 
     * @return JsonResponse
     */
    public function update(
        int $id, 
        EventRepository $eventRepository, 
        Request $request, 
        SerializerInterface $serialiser
        )
    {
        // A event is retrieved according to its id
        $event = $eventRepository->find($id);
        
         // check for "edit" access: calls all voters
         $this->denyAccessUnlessGranted('EVENT_EDIT', $event);
        // If the event does not exist, we return a 404 error
        if (!$event) {
            return $this->json([
                'error' => 'L\'event ' . $id . ' n\'existe pas'
            ], 404);
        }

        // We retrieve the JSON
        $jsonData = $request->getContent();

         // We merge the data from the event with the data
        // from the Front application (insomnia, react, ...)
        // Deserializing in an Existing Object : https://symfony.com/doc/current/components/serializer.html#deserializing-in-an-existing-object
         $event = $serialiser->deserialize($jsonData, Event::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);

         $event->setUpdatedAt(new \DateTimeImmutable());

         // We call the manager to perform the update in DB
         $em = $this->getDoctrine()->getManager();
        
         $em->flush();
       
        return $this->json([
            'message' => 'L\' event ' . $event->getTitle() . ' a bien été mise à jour',
        ], 
        200);
    }

    /**
     * Deleting a event based on its ID
     * 
     * URL : /api/v1/events/{id}
     * Road : api_v1_event_delette
     * 
     * @Route("/{id}", name="delette", requirements={"id":"\d+"}, methods={"DELETE"})
     
     * @return JsonResponse
     */
    public function delete(
        int $id, 
        EventRepository $eventRepository, 
        ParticipationRepository $participationRepository, 
        CommentRepository $commentRepository)
    {
         // A event is retrieved according to its id
         $event = $eventRepository->find($id);
        
          // check for "delete" access: calls all voters
        $this->denyAccessUnlessGranted('EVENT_DELETE', $event);

         // If the event does not exist, we return a 404 error
        if (!$event) {
            return $this->json([
                'error' => 'L\'event ' . $id . ' n\'existe pas'
            ], 404);
        }
        // we get the id of the event 
        $eventId=$event->getId();

        // ---ParticipationRepository--
        // the Participation entity is recovered in the form of a table
        $entityParticipation = $participationRepository->findBy(array('event'=>$eventId));
        // we get the participations linked to the event to validate the deletion if it exists
        $eventParticipation=$event->getParticipations();

        // ---CommentRepository--
        // the Comment entity is recovered in the form of a table
        $entityComment = $commentRepository->findBy(array('event'=>$eventId));
        // we get the Comments linked to the event to validate the deletion if it exists
        $eventComment=$event->getComments();
       
        if ($event!==null) {
            // We call the manager to manage the deletion
            $em = $this->getDoctrine()->getManager();

            if ($eventParticipation!==null) {
                // If we have any participations related to this event, we delete them
                foreach ($entityParticipation as $idParticipation) {
                    $em->remove($idParticipation);
                }
                $em->flush();
            }
            if ($eventComment!==null) {
                // If we have any comments related to this event, we delete them
                foreach ($entityComment as $idComment) {
                    $em->remove($idComment);
                }
                $em->flush();
            }
            $em->remove($event);
        
            $em->flush(); // A DELETE SQL query is performed

            return $this->json(['l\'event avec l\'id '. $id . ' à été suprimer'], 203);
        }
    }
}
