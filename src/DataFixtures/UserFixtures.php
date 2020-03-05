<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        //On commence par mettre en place les roles
        $role1 = new Role();
        $role1->setName('BASIC');
        $manager->persist($role1);
        $role2 = new Role();
        $role2->setName('ADMIN');
        $manager->persist($role2);
        
        // on va créer 2 utilisateurs
        for($i = 0; $i < 2; $i++){
            $user = new User();
            $user->setName($faker->firstName());
            $user->setPassword('password123');
            $user->setRole($role1);
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
        }
        $admin = new User();
        $admin->setName('admin');
        $admin->setPassword('admin');
        $admin->setRole($role2);
        $admin->setCreatedAt(new \DateTime());
        $manager->persist($admin);


        $manager->flush();
    }
}
