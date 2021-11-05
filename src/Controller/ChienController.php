<?php

namespace App\Controller;

use App\Repository\ChienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChienController extends AbstractController
{
    private ChienRepository $chienRepository;

    public function __construct(ChienRepository $chienRepository){
        $this->chienRepository = $chienRepository;
    }
    /**
     * @Route("/chien", name="chien")
     */
    public function index(): Response
    {
        return $this->render('chien/index.html.twig', [
            'controller_name' => 'ChienController',
        ]);
    }

    /**
    *@Route("/adopter/{id}", name="adopter",  requirements={"id"="\d+"})
     */
     public function chienAdopter(int $id,  EntityManagerInterface $em): Response
     {

         $chien = $this->chienRepository->find($id);
         $annonce = $chien->getAnnonce();
         $chien->setIsAdopted(true);
         $em->persist($chien);
         $em->flush();

        return $this->redirectToRoute("annonce_single",['id' => $annonce->getId()]);

     }
}
