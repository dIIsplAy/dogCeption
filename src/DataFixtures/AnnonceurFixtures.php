<?php

namespace App\DataFixtures;

use App\Entity\Annonceur;
use App\Repository\RaceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnonceurFixtures extends Fixture
{
  

    public function __construct()
    {
    }
    public function load(ObjectManager $manager): void
    {
       
     for($i = 0; $i<10;$i ++){
         $annonceur = new Annonceur();
         $annonceur->setEmail('annonceur'.$i.'@gmail.com');
         $annonceur->setPassword('1234' . $i);
         $annonceur->setUser('Annonceur' . $i);
         $annonceur->setRoles([]);
         $manager->persist($annonceur);
     }
        // $product = new Product();

        $manager->flush();
    }
}
