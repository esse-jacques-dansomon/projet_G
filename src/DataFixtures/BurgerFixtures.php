<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BurgerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 100; $i++) { 
            $data = new Burger();
            $data->setName("burger".$i)
                ->setPrice(3500+$i)
                ->setImage("image burger".$i)
                ->setDescription("burger description ".$i);
            $this->addReference("Burger".$i, $data);
            $manager->persist($data);
        }

        $manager->flush();

        
    }
}
