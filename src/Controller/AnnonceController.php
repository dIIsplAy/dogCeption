<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{

    private AnnonceRepository $annonceRepository;
    public function __construct(AnnonceRepository $annonceRepository){
        $this->annonceRepository = $annonceRepository;
    }

    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(): Response
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }
    /**
     * @Route("/annonce/{id}", name="annonce_single", requirements={"id"="\d+"})
     */
    public function singleAnnonce(int $id): Response
    {
        $annonce = $this->annonceRepository->find($id);
        return $this->render('annonce/single.html.twig', [
            "annonce"=> $annonce,
        ]);
    }

    /**
     * @Route("/annonces", name="annonces")
     */
    public function allAnnonces(): Response
    {
        $annonces = $this->annonceRepository->findAll();
        return $this->render('annonce/listAnnonces.html.twig', [
            "annonces"=> $annonces,
        ]);
    }



}
