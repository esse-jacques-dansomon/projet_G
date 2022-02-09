<?php

namespace App\DataFixtures;

use App\Entity\Complement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ComplementFixtures extends Fixture
{

    
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 20; $i++) {
            $data = new Complement();
            $data->setName("complement burger bresil".$i)
                ->setPrice(1500+$i)
                ->setImage("assets/img/products/complement.jpg");
            $this->addReference("Complement".$i, $data);
            $manager->persist($data);
        }

        $manager->flush();
    }
}
