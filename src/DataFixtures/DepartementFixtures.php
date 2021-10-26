<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i<20; $i++){
            $departement = new Departement();
            $departement->setNom('Departement' . $i);
            $manager->persist($departement);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            departementFixtures::class,
        ];
    }
}
