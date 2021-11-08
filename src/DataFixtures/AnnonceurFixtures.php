<?php

namespace App\DataFixtures;

use App\Entity\Annonceur;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AnnonceurFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i ) {
            $annonceur = new Annonceur();
            $annonceur->setEmail('annonceur'.$i.'@gmail.com');
            $pwd = $this->hasher->hashPassword($annonceur, 'motsdepasse123');
            $annonceur->setPassword($pwd);
            $annonceur->setUser('Annonceur'.$i);
            $annonceur->setRoles([]);
            $annonceur->setIsEleveur(false);
            $annonceur->setNomAsso('Elevage du bonnheur');
            $annonceur->setAddresse('6 Avenue de la liberté');
            $annonceur->setTelephone('0654251478');
            $annonceur->setDateInscription(new DateTime());
            $annonceur->setEmail('jhon'.$i.'.doe@gmail.com');
            $annonceur->setIsSpa(true);
            $manager->persist($annonceur);
        }
        // $product = new Product();

        $manager->flush();
    }
}
