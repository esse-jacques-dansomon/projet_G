<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) {
            $data = new Menu();
            $data->setName("Menu burger bresil".$i)
                ->setImage("assets/img/products/menu.jpg")
                ->addComplement($this->getReference("Complement".$i))               
                ->setBurger($this->getReference("Burger".$i))
                ->setDescription("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.  ".$i);
                $data->setPrice(6000);
            $this->addReference("menu".$i, $data);
            $manager->persist($data);
        }

        $manager->flush();
    }
    


    public function getDependencies(): array
    {

        return [
            ComplementFixtures::class,
            BurgerFixtures::class
        ];
    }
    
}
