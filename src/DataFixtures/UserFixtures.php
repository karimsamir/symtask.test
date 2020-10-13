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
        // create admin user

        $admin = new User();
        $admin->setEmail("karim5977@gmail.com");
        // $user->setPassword("Password_123");

        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'Password_123'
        ));

        $admin->setRoles(array("ROLE_ADMIN", "ROLE_USER"));
        

        $manager->persist($admin);



        $user = new User();
        $user->setEmail("karim_samir@outlook.com");
        // $user->setPassword("Password_123");

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Password_123'
        ));

        $user->setRoles(array("ROLE_USER"));
        
        $manager->persist($user);

        $manager->flush();
    }
}
