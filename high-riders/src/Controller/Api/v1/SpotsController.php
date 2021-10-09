<?php

namespace App\Controller\Api\v1;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\DepartementRepository;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;
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
 * @Route("/api/v1/spots", name="api_v1_spot_", methods={"GET"})
 */
class SpotsController extends AbstractController
{
    /**
     * Display all spots
     * 
     * URL : /api/v1/spots/
     * Road : api_v1_spot_index
     * 
     * @Route("/", name="index")
     */
    public function index(SpotRepository $spotRepository, CategoryRepository $categoryRepository, DepartementRepository $departementRepository): Response
    {
        // We retrieve the series stored in BDD
        $spots = $spotRepository->findAll();
        $category = $categoryRepository->findAll();
        $departement = $departementRepository->findAll();
        // Return the list in JSON format
        // To solve the bug : Reference circular
        return $this->json([$spots,$category,$departement], 200, [], [
            // This input to the Serialiser to transform the objects
            // objects into JSON, fetching only the properties
            // tagged with the name spot_list
            'groups' => 'spot_list',
        ]);
    }

      /**
     
     *
     * Displays the details of a spot according to
     * its ID
     * 
     * URL : /api/v1/spots/{id}
     * Road : api_v1_spot_show
     * 
     * @Route("/{id}", name="_show", requirements={"id":"\d+"}, methods={"GET"})
     * 
     
     * @return JsonResponse
     */
    public function show(int $id, SpotRepository $spotRepository)
    {
        // A spot is retrieved according to its id
        $spot = $spotRepository->find($id);

         // If the spot does not exist, we return a 404 error
        if (!$spot) {
            return $this->json([
                'error' => 'Le spot ' . $id . ' n\'existe pas'
            ], 404);
        }

       
        return $this->json($spot, 200, [], [
            // Return the result in JSON format
            // tagged with the name spot_detail
            'groups' => 'spot_detail'
        ]);
    }

     /**
     * Allows the creation of a new spot
     * 
     * URL : /api/v1/spots/
     * 
     * @Route("/add", name="add", methods={"POST"})
     *
     * @return void
     */
    public function add( Request $request, SerializerInterface $serialiser, ValidatorInterface $validator,SluggerInterface $sluggerInterface,
    UserService $service)
    {
         // We retrieve the JSON
         $jsonData = $request->getContent();

         //  We transform the json into an object : deserialization
         // - We indicate the data to transform (deserialize)
         // - We indicate the format of arrival after conversion (object of type spot)
         // - We indicate the format of departure: we want to pass from json towards an object spot
         $spot = $serialiser->deserialize($jsonData, Spot::class, 'json');
        
         // We validate the data stored in the $spot object based on
         // on the critieria of the @Assert annotation of the entity (cf. src/Entity/spot.php)
         
        // If the error array is not empty (at least 1 error)
        // count allows to count the number of elements of an array
        // count([1, 2, 3]) ==> 3
        $errors = $validator->validate($spot);

        if(count($errors) > 0){

            // Code 400 : bad request , the data received is not
            // not compliant
            return $this->json($errors, 400);
            
        }else{

             // add a User Id with UserService
             $user = $service->getCurrentUser();

             // recovery the spot's title
             $title = $spot->getTitle();

             // transform in slug
             $slug = $sluggerInterface->slug(strtolower($title));
 
             // update the entity
             $spot->setSlug($slug);
            
             $spot->setAuthor($user);

            // To save, we call the manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($spot);
            $em->flush();

            // A response is returned indicating that the resource
            // has been created (http code 201)
            return $this->json($spot, 201, [], [
                'groups' => ['spot_detail'],
            ]);
        }

    }

     /**
     * Allows the creation of a new spot
     * 
     *  URL : /api/v1/spots/{id}/comment
     * Road : api_v1_spot_addComment
     * @Route("/{id}/comment", name="addComment", requirements={"id":"\d+"}, methods={"POST"})
     *
     * @return void
     */
    public function addComment(Spot $spot, Request $request, SerializerInterface $serialiser, ValidatorInterface $validator, UserService $service)
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
             $spot->getId();
            // update the entity
            $comment->setUser($user);
            $comment->setSpot($spot);

            // To save, we call the manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            // A response is returned indicating that the resource
            // has been created (http code 201)
            return $this->json($comment, 201, [], [
                'groups' => ['spot_detail'],
            ]);
        }

    }

     /**
     * Deleting a spot based on its ID
     * 
     * URL : /api/v1/spots/{id}/comment/{id}
     * Road : api_v1_spot_removeComment
     * 
     * @Route("/{spot}/comment/{id}", name="removeComment", requirements={"id":"\d+"}, methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function removeComment(int $id, CommentRepository $commentRepository)
    {
         // A comment is retrieved according to its id
         $comment = $commentRepository->find($id);
        // dd($comment);
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
     * Allows the creation of a new spot
     * 
     *  URL : /api/v1/spots/{id}/like
     * Road : api_v1_spot_addLike
     * @Route("/{id}/like", name="addLike", requirements={"id":"\d+"}, methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function addLike(int $id, SpotRepository $spotRepository, Request $request, SerializerInterface $serialiser, ValidatorInterface $validator, UserService $service)
    {
         //  $this->denyAccessUnlessGranted('edit', $user, "Vous n'avez pas accés à cette page' !");
        // A spot is retrieved according to its id
        $spot = $spotRepository->find($id);
        
        
        // If the spot does not exist, we return a 404 error
        if (!$spot) {
            return $this->json([
                'error' => 'La spot ' . $id . ' n\'existe pas'
            ], 404);
        }


        // We retrieve the JSON
        $jsonData = $request->getContent();

         // We merge the data from the spot with the data
        // from the Front application (insomnia, react, ...)
        // Deserializing in an Existing Object : https://symfony.com/doc/current/components/serializer.html#deserializing-in-an-existing-object
         $spot = $serialiser->deserialize($jsonData, Spot::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $spot]);
        
         $spotLike = $spot->getSLike();
         $addLike =($spotLike + 1);

         $spot->setSLike($addLike);
         // We call the manager to perform the update in DB
         $em = $this->getDoctrine()->getManager();
        
         $em->flush();
       
         return $this->json($spot, 200, [], [
            'groups' => ['spot_detail'],
        ]);
    }

     /**
     * Allows the creation of a new spot
     * 
     * URL : /api/v1/spots/{id}/dislike
     * Road : api_v1_spot_removeLike
     * 
     * @Route("/{id}/dislike", name="removeLike", requirements={"id":"\d+"}, methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function removeLike(int $id, SpotRepository $spotRepository, Request $request, SerializerInterface $serialiser, ValidatorInterface $validator, UserService $service)
    {
         //  $this->denyAccessUnlessGranted('edit', $user, "Vous n'avez pas accés à cette page' !");
        // A spot is retrieved according to its id
        $spot = $spotRepository->find($id);
        
        
        // If the spot does not exist, we return a 404 error
        if (!$spot) {
            return $this->json([
                'error' => 'La spot ' . $id . ' n\'existe pas'
            ], 404);
        }


        // We retrieve the JSON
        $jsonData = $request->getContent();

         // We merge the data from the spot with the data
        // from the Front application (insomnia, react, ...)
        // Deserializing in an Existing Object : https://symfony.com/doc/current/components/serializer.html#deserializing-in-an-existing-object
         $spot = $serialiser->deserialize($jsonData, Spot::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $spot]);
        
         $spotLike = $spot->getSLike();
         $removeLike =($spotLike - 1);

         $spot->setSLike($removeLike);
         // We call the manager to perform the update in DB
         $em = $this->getDoctrine()->getManager();
        
         $em->flush();
       
         return $this->json($spot, 200, [], [
            'groups' => ['spot_detail'],
        ]);
    }

     /**
     *
     * Update of a spot according to
     * its Identifier
     * 
     * URL : /api/v1/spots/{id}
     * Road : api_v1_spot_update
     * @Route("/{id}", name="update", requirements={"id":"\d+"}, methods={"PUT", "PATCH"})
     * 
     
     * @return JsonResponse
     */
    public function update(int $id, SpotRepository $spotRepository, Request $request, SerializerInterface $serialiser)
    {
        //  $this->denyAccessUnlessGranted('edit', $user, "Vous n'avez pas accés à cette page' !");
        // A spot is retrieved according to its id
        $spot = $spotRepository->find($id);
        
        // check for "edit" access: calls all voters
        $this->denyAccessUnlessGranted('SPOT_EDIT', $spot);
        // If the spot does not exist, we return a 404 error
        if (!$spot) {
            return $this->json([
                'error' => 'La spot ' . $id . ' n\'existe pas'
            ], 404);
        }


        // We retrieve the JSON
        $jsonData = $request->getContent();

         // We merge the data from the spot with the data
        // from the Front application (insomnia, react, ...)
        // Deserializing in an Existing Object : https://symfony.com/doc/current/components/serializer.html#deserializing-in-an-existing-object
         $spot = $serialiser->deserialize($jsonData, Spot::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $spot]);

         $spot->setUpdatedAt(new \DateTimeImmutable());
         // We call the manager to perform the update in DB
         $em = $this->getDoctrine()->getManager();
        
         $em->flush();
       
        return $this->json([
            'message' => 'La spot ' . $spot->getTitle() . ' a bien été mise à jour',
        ], 
        200);
    }

     /**
     * Deleting a spot based on its ID
     * 
     * URL : /api/v1/spots/{id}
     * Road : api_v1_spot_delette
     * 
     * @Route("/{id}", name="delette", requirements={"id":"\d+"}, methods={"DELETE"})
     
     * @return JsonResponse
     */
    public function delete(int $id,  SpotRepository $spotRepository,  CommentRepository $commentRepository)
    {
        // A spot is retrieved according to its id
        $spot = $spotRepository->find($id);
        
        // check for "delete" access: calls all voters
        $this->denyAccessUnlessGranted('SPOT_DELETE', $spot);
        // If the spot does not exist, we return a 404 error
        if (!$spot) {
            return $this->json([
                'error' => 'La spot ' . $id . ' n\'existe pas'
            ], 404);
        }
        // we get the id of the event 
        $spotId=$spot->getId();
 
        // ---COmmentRepository--
        // the Comment entity is recovered in the form of a table
        $entityComment = $commentRepository->findBy(array('spot'=>$spotId));
        // we get the Comments linked to the event to validate the deletion if it exists
        $spotComment=$spot->getComments();

        if ($spot!==null) {
            // We call the manager to manage the deletion
            $em = $this->getDoctrine()->getManager();
            if ($spotComment!==null) {
                
                foreach ($entityComment as $idComment) {
                    $em->remove($idComment);
                }
                $em->flush();
            }
            
            $em->remove($spot);
            $em->flush(); // A DELETE SQL query is performed

        return $this->json(['la spot avec l\'id '. $id . ' à été suprimer'], 203);
        }
    }
}
