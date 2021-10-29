<?php

namespace App\Controller;

use App\Entity\Annonceur;
use App\Repository\AnnonceurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceurController extends AbstractController

{
private AnnonceurRepository $annonceurRepository;

public function __construct(AnnonceurRepository $annonceurRepository){
    $this->annonceurRepository = $annonceurRepository;
}
      /**
     * @Route("/annonceur/{id}", name="annonceur_single", requirements={"id"="\d+"})
     */
    public function singleAnnonceur(Annonceur $annonceur): Response
    {
        $annoncesList = $annonceur->getListeAnnonce();
        return $this->render('annonceur/singleAnnonceur.html.twig', [
            "annonceur"=>$annonceur,
            // "listeAnnonces"=>$annoncesList
        ]);
    }
}
