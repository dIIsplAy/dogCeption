<?php

namespace App\Controller;

use App\Repository\ChienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private ChienRepository $chienRepository;
    public function __construct(ChienRepository $chienRepository)
    {
        $this->chienRepository = $chienRepository;
    }
    /**
     * @Route("/", name="")
     */
    public function index(): Response
    {
        $chiens = $this->chienRepository->findAll();
        return $this->render('default/index.html.twig', ["chiens"=>$chiens,
            'controller_name' => 'DefaultController',
        ]);
    }
}
