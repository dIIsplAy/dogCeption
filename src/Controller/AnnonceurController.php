<?php

namespace App\Controller;

use App\Entity\Annonceur;
use App\Form\EditAnnonceurType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceurController extends AbstractController
{

    // public function __construct(AnnonceurRepository $annonceurRepository)
    // {
    //     $this->annonceurRepository = $annonceurRepository;
    // }

    /**
     * @Route("/annonceur/{id}", name="annonceur_single", requirements={"id"="\d+"})
     */
    public function singleAnnonceur(Annonceur $annonceur): Response
    {
        $annoncesList = $annonceur->getListeAnnonce();

        return $this->render('annonceur/singleAnnonceur.html.twig', [
            'annonceur' => $annonceur,
            // "listeAnnonces"=>$annoncesList
        ]);
    }

    /**
     * @Route("/compte_annonceur", name="compte_annonceur")
     * @isGranted("ROLE_ANNONCEUR")
     */
    public function detailCompte(Request $request, EntityManagerInterface $em)
    {
        $annonceur = $this->getUser();
        $form = $this->createForm(EditAnnonceurType::class, $annonceur, [
            'method' => 'POST',
            // 'action' => $this->generateUrl(''),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonceur);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('annonceur/compteAnnonceur.html.twig', [
            'annonceur' => $annonceur,
            'form' => $form->createView(),
        ]);
    }
}
