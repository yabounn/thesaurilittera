<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $email, $password, $roles]) {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setCreatedAt(new \DateTime());
            $user->setRoles($roles);


            $manager->persist($user);
            $this->addReference($username, $user);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['yann', 'yann@yann.com', 'yannyann', ['ROLE_ADMIN']],
            ['ya', 'ya@ya.com', 'useruser', ['ROLE_USER']],

        ];
    }
}
