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
        for ($i=0; $i < 40; $i++) { 
            $data = new Menu();
            $data->setName("Menu".$i)  
                ->setImage("image burger".$i)
                ->addComplement($this->getReference("Complement".$i))               
                ->setBurger($this->getReference("Burger".$i))
                ->setDescription("menu description ".$i);
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
