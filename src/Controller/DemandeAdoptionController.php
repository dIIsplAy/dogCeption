<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DemandeAdoption;
use App\Entity\Message;
use App\Form\DemandeAdoptionType;
use App\Form\MessageType;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeAdoptionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdoptionController extends AbstractController
{
    private AnnonceRepository $annonceRepository;
    private DemandeAdoptionRepository $demandeAdoptionRepository;



    public function  __construct(AnnonceRepository $annonceRepository, DemandeAdoptionRepository $demandeAdoptionRepository)
    {
        $this->annonceRepository = $annonceRepository;
        $this->demandeAdoptionRepository = $demandeAdoptionRepository;
    }
    /**
     * @Route("/demande_adoption/{id}", name="demande_adoption", requirements={"id"="\d+"})
     */
    public function newDemandeAdoption(Request $request, int $id, EntityManagerInterface $em): Response
    {
        $adoption = new DemandeAdoption();
        $annonce = $this->annonceRepository->find($id);
        $annonceur = $annonce->getAnnonceur();
        $client = $this->getUser();
        $message = new Message();
        $adoption->addMessage($message);
        
        $form = $this->createForm(DemandeAdoptionType::class, $adoption, [
            'method' => 'POST',
            'id' => $id,
            // 'action' => $this->generateUrl('demande_adoption'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $defaultMessage = 'Bonjour je souhaiterais vous concatez concernant une potentiel adoption';
            if (empty($message->getContent())) {
                $message->setContent($defaultMessage);
            }
            $message->setDateEnvoie(new DateTime());
            $message->setClient($client);
            $adoption->setDateEnvoie(new DateTime());
            $adoption->setStatut('non pourvu');
            $adoption->setValider(false);
            $adoption->setAnnonce($annonce);
            $adoption->setClient($client);
            //recup message , demande adoption relation cascade persist
            $em->persist($adoption);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('adoption/adoption.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(int $id,  EntityManagerInterface $em) {
        $demande = $this->demandeAdoptionRepository->find($id);
        // dd($demande);
        $annonce = $demande->getAnnonce();
        $annonceur = $annonce->getAnnonceur();
        $user = $this->getUser();
        if($user->getId() == $annonceur->getId()) {
        $em->remove($demande);
        $em->flush();
        }
       return $this->redirectToRoute('compte_annonceur');

    }

    /**
     * @Route("/single_adoption/{id}", name="single_adoption", requirements={"id"="\d+"})
     */
     public function singleAdoption(DemandeAdoption $demande, Request $request, EntityManagerInterface $em) {
            $message = new Message();
            $message->setDemandeAdoption($demande);
            $client = $this->getUser();

            $form = $this->createForm(MessageType::class, $message, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setDateEnvoie(new DateTime());
            if ($client instanceof Client) {
                $message->setClient($client);
            }
            //recup message , demande adoption relation cascade persist
            $em->persist($message);
            $em->flush();
     }
        return $this->render('adoption/single.html.twig', [
            'demande' => $demande,
            'annonce' => $demande->getAnnonce(),
            'formMessage' => $form->createView(),
        ]);


    }

    
}
