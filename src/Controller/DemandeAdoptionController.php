<?php

namespace App\Controller;

use App\Entity\Annonceur;
use App\Entity\Client;
use App\Entity\DemandeAdoption;
use App\Entity\Message;
use App\Form\DemandeAdoptionType;
use App\Form\MessageType;
use App\Repository\AnnonceRepository;
use App\Repository\DemandeAdoptionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdoptionController extends AbstractController
{
    private AnnonceRepository $annonceRepository;
    private DemandeAdoptionRepository $demandeAdoptionRepository;

    public function __construct(AnnonceRepository $annonceRepository, DemandeAdoptionRepository $demandeAdoptionRepository)
    {
        $this->annonceRepository = $annonceRepository;
        $this->demandeAdoptionRepository = $demandeAdoptionRepository;
    }

    /**
     * @Route("/demande_adoption/{id}", name="demande_adoption", requirements={"id"="\d+"})
     *@IsGranted("ROLE_CLIENT")
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
    public function delete(int $id, EntityManagerInterface $em)
    {
        $demande = $this->demandeAdoptionRepository->find($id);
        // dd($demande);
        $annonce = $demande->getAnnonce();
        $annonceur = $annonce->getAnnonceur();
        $user = $this->getUser();
        if ($user->getId() == $annonceur->getId()) {
            $em->remove($demande);
            $em->flush();
        }

        return $this->redirectToRoute('compte_annonceur');
    }

    /**
     * @Route("/single_adoption/{id}", name="single_adoption", requirements={"id"="\d+"})
     */
    public function singleAdoption(DemandeAdoption $demande, Request $request, EntityManagerInterface $em)
    {
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

    /**
     * @Route("/valider_demande/{id}", name="valider_demande", requirements={"id"="\d+"})
     */
    public function validerDemande(int $id, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $demande = $this->demandeAdoptionRepository->find($id);
        $demandeListeChiens = $demande->getChien();
        $annonce = $demande->getAnnonce();
        $listeChiens = $annonce->getListeChien();
        $annonceur = $annonce->getAnnonceur();

        if ($user->getId() == $annonceur->getId()) {
            $demande->setValider(true);
            $em->persist($demande);
            foreach ($demandeListeChiens as $chien) {
                $chien->setIsAdopted(true);
                $em->persist($chien);
            }
            $bool = true;
            foreach ($listeChiens as $chien) {
                if (!$chien->getIsAdopted()) {
                    $bool = false;
                }
            }
            if ($bool) {
                $annonce->setPourvu(true);
                $em->persist($annonce);
            }
            $em->flush();

            return $this->redirectToRoute('compte_annonceur');
        }
    }

    /**
     * @Route("messages_read/{id}", name="messages_read")
     */
    public function messageLue(EntityManagerInterface $em, DemandeAdoption $demande)
    {
        $user = $this->getUser();
        if ($user instanceof Annonceur) {
            if ($demande->getAnnonce()->getAnnonceur()->getId() != $user->getId()) {
                return $this->createAccessDeniedException('Nope');
            }

            foreach ($demande->getMessage() as $message) {
                if ($message->getClient()) {
                    $message->setLue(true);
                    $em->persist($message);
                }
            }

            // $annonceurAnnonce = $user->getListeAnnonce();
            // foreach($annonceurAnnonce as $annonce){
            //     foreach($annonce->getDemandeAdoption() as $demande){
            //         foreach($demande->getMessage() as $message){
            //             $message->setLue(true);
            //             $em->persist($message);
            //         }
            //     }
            // }
        } elseif ($user instanceof Client) {
            foreach ($demande->getMessage() as $message) {
                if (!$message->getClient()) {
                    $message->setLue(true);
                    $em->persist($message);
                }
            }
        }
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}
