<?php

namespace App\DataFixtures;

use App\Entity\Race;
use App\Entity\Chien;
use App\Repository\RaceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChienFixtures extends Fixture implements DependentFixtureInterface
{
    private RaceRepository $raceRepository;

    public function __construct(RaceRepository $raceRepository )
    {
        $this->raceRepository = $raceRepository;
    }
    public function load(ObjectManager $manager): void
    {
        $cpt= 0;
        $races = $this->raceRepository->findAll();
        foreach($races as $race){
            $chien = new Chien();
            $chien->setNom('Chien' . $cpt);
            // $chien->setAnnonce($cpt);
            $chien->setDescription('lorem ipsum dolor toto');
            $chien->setIsAdopted(false);
            $chien->setIsFriendly(true);
            $chien->setLof(true);
            $manager->persist($chien);
            $cpt++;
            
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
