<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $raceNames = [
            'Bulldog',
            'Labrador',
            'German Shepherd',
            'Siberian Husky',
            'Chiuahua',
            'Dobermann',
            'Rottweiler',
            'Pug',
            'Shiba Inu',
            'Border Colie',
        ];

        foreach ($raceNames as $raceName) {
            $race = new Race();
            $race->setNom($raceName);
            $manager->persist($race);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RaceFixtures::class,
        ];
    }
}
