<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture 
{


    public function __construct()
    {
    }
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 1; $i++) {
            $admin = new Admin();
            $admin->setEmail('admin@gmail.com');
            $admin->setUser('Admin');
            $admin->setPassword('admin123');
            $admin->setRoles([]);
            $manager->persist($admin);
        }

        $manager->flush();
    }
}
