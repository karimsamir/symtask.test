<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("karim5977@gmail.com");
        // $user->setPassword("Password_123");

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Password_123'
        ));

        $manager->persist($user);

        $manager->flush();
    }
}
