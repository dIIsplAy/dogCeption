<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
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
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('client/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
