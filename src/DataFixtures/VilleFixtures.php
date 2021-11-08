<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use App\Repository\DepartementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture implements DependentFixtureInterface
{
    private DepartementRepository $departementRepository;

    public function __construct(DepartementRepository $departementRepository)
    {
        $this->departementRepository = $departementRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $departements = $this->departementRepository->findAll();
        $cpt = 0;
        foreach ($departements as $departement) {
            $ville1 = new Ville();
            $ville1->setDepartement($departement);
            $ville1->setNom('Ville'.$cpt);
            $ville1->setZipCode(1000 + $cpt);

            $ville2 = new Ville();
            $ville2->setDepartement($departement);
            $ville2->setNom('Ville'.$cpt);
            $ville2->setZipCode(1000 + $cpt);
            $manager->persist($ville1, $ville2);
            ++$cpt;
        }
        // $product = new Product();

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DepartementFixtures::class,
        ];
    }
}
