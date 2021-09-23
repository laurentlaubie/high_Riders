<?php

namespace App\Controller\Backoffice;

use App\Entity\Spot;
use App\Form\SpotsType;
use App\Repository\SpotRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/** 
    * @Route("/backoffice/spots", name="backoffice_", requirements={"id":"\d+"} )
    */
class SpotsController extends AbstractController
{
    // ===================== Page spots Display  =================//
    /**
     * @Route("/", name="spots", methods={"GET"})
     */
    public function index(SpotRepository $spotRepository): Response
    {
        $spotsShow = $spotRepository->findAll();

        return $this->render('backoffice/spots/index.html.twig', [
            'spots' => $spotsShow,
        ]);
    }

    


    // ===================== Page spot Display by id  =================//
    /**
    * @Route("/{id}", name="spot_show",  methods={"GET"})
    */
    public function show(Spot $spot): Response
    {
        return $this->render('backoffice/spots/show.html.twig', [
        'spot' => $spot,
        ]);
    }



    // ===================== Page add spot  =================//
    /**
    * @Route("/add", name="spot_add", methods={"GET","POST"}, priority=2)
    */
    public function add(Request $request, ImageUploader $imageUploader, SluggerInterface $slugger) :Response
    {
        $spot = new Spot();
        $form = $this->createForm(SpotsType::class, $spot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $imageFile = $imageUploader->upload($form, 'image');
            // dd($imageFile);
            // if ($imageFile) {
            //     $spot->setImage($imageFile);
            // }
           
            // recovery the spot's title
            $title = $spot->getTitle();

            // transform in slug
            $slug = $slugger->slug(strtolower($title));

            // update the entity
            $spot->setSlug($slug);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spot);
            $entityManager->flush();

            

            return $this->redirectToRoute('backoffice_spots', [], Response::HTTP_SEE_OTHER);
        }
            return $this->renderForm('backoffice/spots/add.html.twig', [
                'spot' => $spot,
                'form' => $form,
            ]);

    }

    // // ===================== Page edit spot  =================//
    
        


}
