<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BurgerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 15; $i++) {
            $data = new Burger();
            $data->setName("burger bresil ".$i)
                ->setPrice(3500+$i)
                ->setImage('assets/img/products/burger.jpg')
                ->setDescription("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.  ".$i);
            $this->addReference("Burger".$i, $data);
            $manager->persist($data);
        }

        $manager->flush();

        
    }
}
