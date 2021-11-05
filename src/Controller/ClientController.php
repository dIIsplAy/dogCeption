<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\EditClientType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ClientController extends AbstractController
{
    private UserPasswordHasherInterface $hashPwd;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hashPwd = $hasher;
    }
    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
        /**
     * @Route("/inscription", name="inscription")
     */
    public function newClient(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
         $form = $this->createForm(ClientType::class, $client, [
            'method' => 'POST',
            'action' => $this->generateUrl('inscription'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setDateInscription(new DateTime());
            $client->setPassword($this->hashPwd->hashPassword($client, $client->getPlainPassword()));
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('client/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/compte", name="compte")
     * @IsGranted("ROLE_CLIENT")
     */
     public function detailCompte(Request $request, EntityManagerInterface $em)
     {
        $client = $this->getUser();
         $form = $this->createForm(EditClientType::class, $client, [
            'method' => 'POST',
            // 'action' => $this->generateUrl(''),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
         return $this->render('client/compte.html.twig', [
            'client'=>$client,
            'form' => $form->createView(),
        ]);
     }
}
