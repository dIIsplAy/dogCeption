<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\AnnonceurRepository;
use App\Repository\ChienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private AnnonceurRepository $annonceurRepository;
    private AnnonceRepository $annonceRepository;
    private ChienRepository $chienRepository;
    public function __construct(ChienRepository $chienRepository, AnnonceRepository $annonceRepository,
    AnnonceurRepository $annonceurRepository)
    {
        $this->annonceurRepository = $annonceurRepository;
        $this->chienRepository = $chienRepository;
        $this->annonceRepository = $annonceRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function getDataHome():Response
    {
        $annonceurs = $this->annonceurRepository->findAll();
        $annonces = $this->annonceRepository->getThreeAnnonce();
        return $this->render('default/index.html.twig',
         ["annonces"=>$annonces,
         "annonceurs"=>$annonceurs,
        ]);
    }
}
