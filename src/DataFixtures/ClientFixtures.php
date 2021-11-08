<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Repository\VilleRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    private VilleRepository $villeRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(VilleRepository $villeRepository, UserPasswordHasherInterface $hasher)
    {
        $this->villeRepository = $villeRepository;
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $cpt = 0;
        $villes = $this->villeRepository->findAll();
        foreach ($villes as $ville) {
            $client = new Client();
            $client->setEmail('client'.$cpt.'@gmail.com');
            $pwd = $this->hasher->hashPassword($client, 'motsdepasse123');
            $client->setPassword($pwd);
            $client->setUser('Client'.$cpt);
            $client->setRoles([]);
            $client->setEmail('jhonny'.$cpt.'.doe@gmail.com');
            $client->setTelephone('0645877889');
            $client->setDateInscription(new DateTime());
            $client->setAdresse('6 Avenue de la liberté');
            $client->setVille($ville);
            $manager->persist($client);
            ++$cpt;
        }

        // $product = new Product();
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
        ];
    }
}
