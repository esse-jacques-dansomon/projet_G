<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{

    private $encoder;

    public function  __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=200; $i++) {
            $data= new Client();
            $data->setEmail("client".$i."@gmail.com")
                ->setLastname("lastname ".$i)
                ->setFirstname("firstname ".$i)
                 ->setTelephone("Telephone ".$i);
            $plainPassword = 'azerty@123';
            $passwordEncode= $this->encoder->hashPassword($data, $plainPassword);
            $data->setPassword($passwordEncode);
            $this->addReference("Client".$i, $data);

        }

        $manager->flush();
    }
}
