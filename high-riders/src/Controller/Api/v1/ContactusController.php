<?php

namespace App\Controller\Api\v1;

use App\Entity\Contactus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/contactus", name="api_v1_contactus_")
 */
class ContactusController extends AbstractController
{
      /**
     * Allows the creation of a new contact form
     * 
     * URL : /api/v1/contactus/
     * 
     * @Route("/", name="add", methods={"POST"})
     * @return void
     */
    public function add(
        Request $request, 
        SerializerInterface $serialiser, 
        ValidatorInterface $validator)
    {
         // We retrieve the JSON
         $jsonData = $request->getContent();

         //  We transform the json into an object : deserialization
         // - We indicate the data to transform (deserialize)
         // - We indicate the format of arrival after conversion (object of type event)
         // - We indicate the format of departure: we want to pass from json towards an object event
         $message = $serialiser->deserialize($jsonData, Contactus::class, 'json');
 
         // We validate the data stored in the $event object based on
         // on the critieria of the @Assert annotation of the entity (cf. src/Entity/event.php)
        

        // If the error array is not empty (at least 1 error)
        // count allows to count the number of elements of an array
        // count([1, 2, 3]) ==> 3
        $errors = $validator->validate($message);

        if(count($errors) > 0){

            // Code 400 : bad request , the data received is not
            // not compliant
            return $this->json($errors, 400);
            
        }else{
            $message->setCreatedAt(new \DateTimeImmutable());

            // To save, we call the manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            // A response is returned indicating that the resource
            // has been created (http code 201)
          return $this->json($message, 201);
        }

    }
}
