<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Repository\ChienRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    private ChienRepository $chienRepository;

    public function __construct(ChienRepository $chienRepository)
    {
        $this->chienRepository = $chienRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $chiens = $this->chienRepository->findAll();
        foreach ($chiens as $chien) {
            $photo = new photo();
            $photo->setImgUrl('https://post.medicalnewstoday.com/wp-content/uploads/sites/3/2020/02/322868_1100-800x825.jpg');
            $photo->setChien($chien);
            $manager->persist($photo);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ChienFixtures::class,
        ];
    }
}
