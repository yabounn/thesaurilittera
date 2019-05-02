<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $user->setFirstname($faker->firstName)
                 ->setName($faker->lastName)
                 ->setUsername($faker->userName)
                 ->setEmail($faker->email)
                 ->setPassword($faker->password) // A HASHER
                 ->setAddress($faker->address)
                 ->setCreatedAt(new \DateTime());

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
