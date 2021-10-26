<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Repository\RaceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
  

    public function __construct()
    {
    }
    public function load(ObjectManager $manager): void
    {
       
     
        // $product = new Product();

        // $manager->flush();
    
}
}
