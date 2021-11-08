<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    private AnnonceRepository $annonceRepository;

    public function __construct(AnnonceRepository $annonceRepository)
    {
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
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/annonces", name="annonces")
     */
    public function allAnnonces(): Response
    {
        $annonces = $this->annonceRepository->findAll();

        return $this->render('annonce/listAnnonces.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    /**
     * @Route("/nouvelle_annonce", name="nouvelle_annonce")
     * @IsGranted("ROLE_ANNONCEUR")
     */
    public function newAnnonce(Request $request, EntityManagerInterface $em): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        $annonceur = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setDatePublication(new DateTime());
            $annonce->setAnnonceur($annonceur);
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('annonce/annonceForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete_annonce/{id}", name="delete_annonce", requirements={"id"="\d+"})
     */
    public function deleteAnnonce(int $id, EntityManagerInterface $em)
    {
        $annonce = $this->annonceRepository->find($id);
        $annonceur = $annonce->getAnnonceur();
        $user = $this->getUser();
        if ($user->getId() == $annonceur->getId()) {
            $em->remove($annonce);
            $em->flush();
        }

        return $this->redirectToRoute('compte_annonceur');
    }
}
