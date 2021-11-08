<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Admin;
use App\Entity\Annonceur;
use App\Entity\Chien;
use App\Entity\Client;
use App\Entity\Race;
use App\Repository\AnnonceRepository;
use App\Repository\ChienRepository;
use App\Repository\ClientRepository;
use App\Repository\MessageRepository;

class DashboardController extends AbstractDashboardController
{
    private AnnonceRepository $annonceRepository;
    private ChienRepository $chienRepository;
    private ClientRepository $clientRepository;
    private MessageRepository $messageRepository;
    public function __construct(AnnonceRepository $annonceRepository,ChienRepository $chienRepository,ClientRepository $clientRepository,MessageRepository $messageRepository  ){
        $this->annonceRepository = $annonceRepository;
        $this->chienRepository = $chienRepository;
        $this->messageRepository = $messageRepository;
        $this->clientRepository = $clientRepository;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $nbChienAdopted = $this->chienRepository->chienAdopter();
        $clientInscrit = $this->clientRepository->clientInscrit();
        $annoncePublier = $this->annonceRepository->annoncePublier();
        $annoncePublierPourvu = $this->annonceRepository->annoncePublierPourvu();
                return $this->render('admin/mainDashboard.html.twig', [
                'chienAdopter' => $nbChienAdopted,
                'clientInscrit' => $clientInscrit,
                'annoncePublier' => $annoncePublier,
                'annoncePublierPourvu' => $annoncePublierPourvu
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="https://cdn.dribbble.com/users/3390157/screenshots/6315498/1_4x.png?compress=1&resize=400x300">DogCeption')
            ->setTranslationDomain('my-custom-domain')
            ->disableUrlSignatures();
    }

    public function configureMenuItems(): iterable
    {
                return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Ajouter des entity'),
            MenuItem::linkToCrud('Admin', 'fa fa-space-shuttle', Admin::class),
            MenuItem::linkToCrud('Annonceur', 'fa fa-money', Annonceur::class),
            MenuItem::linkToCrud('Client', 'fa fa-user-circle-o', Client::class),
            MenuItem::linkToCrud('Chien', 'fas fa-paw', Chien::class),
            MenuItem::linkToCrud('Race', 'far fa-plus-square', Race::class),
            // MenuItem::linkToLogout('Logout', 'fa fa-exit'),

            // MenuItem::section('Users'),
            // MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),
            // MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
        ];

        
    }
}
