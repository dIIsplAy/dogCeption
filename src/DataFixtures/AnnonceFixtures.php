<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Repository\AnnonceurRepository;
use App\Repository\ChienRepository;
use App\Repository\RaceRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
  
private AnnonceurRepository $annonceurRepository;
private ChienRepository $chienRepository;
    public function __construct(AnnonceurRepository $annonceurRepository, ChienRepository $chienRepository)
    {
        $this->annonceurRepository = $annonceurRepository;
        $this->chienRepository = $chienRepository;
    }
    public function load(ObjectManager $manager): void
    {
       $annonceurs = $this->annonceurRepository->findAll();
       $chiens = $this->chienRepository->findAll();
         foreach($annonceurs as $annonceur){
         $rand = rand(0, count($chiens) -1);
         $chien1 = $chiens[$rand];
         $chien2 = $chiens[$rand];
         $annonce = new Annonce();
         $annonce->setDatePublication(new DateTime());
         $annonce->setTitre('Adopter ce mignon dogo');
         $annonce->setDescription('lorem ipsum dolor sit amet, consectetur adipis, lorem ipsum dolor sit am lorem ips dolor sit amet, consectetur adipis, lorem ipsum dolor sit amlorem ipsum dolor sit amet, consectetur adipis, lorem');
         $annonce->setAnnonceur($annonceur);
         $annonce->addListeChien($chien1, $chien2);
         $annonce->setPourvu(false);
         $manager->persist($annonce);
     }

        $manager->flush();
    }
        public function getDependencies()
    {
        return [
            AnnonceurFixtures::class,
            ChienFixtures::class,
        ];
    }
}
