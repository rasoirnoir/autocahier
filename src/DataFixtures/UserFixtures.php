<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        
        // on va créer 2 utilisateurs
        for($i = 0; $i < 2; $i++){
            $user = new User();
            $user->setName($faker->firstName());
            $user->setPassword('password123');
            $user->setRole('ROLE_BASIC');
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
        }
        $admin = new User();
        $admin->setName('admin');
        $admin->setPassword('admin');
        $admin->setRole('ROLE_ADMIN');
        $admin->setCreatedAt(new \DateTime());
        $manager->persist($admin);


        $manager->flush();
    }
}
