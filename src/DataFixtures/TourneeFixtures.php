<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use App\Entity\Tournee;
use App\Entity\Libelle;
use App\Entity\Pdi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TourneeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //création d'une seule tournée pour le moment
        $faker = \Faker\Factory::create('fr_FR');

        $ville = new Ville();
        $ville->setPostalCode($faker->postcode());
        $ville->setName($faker->city());
        $ville->setCreatedAt(new \DateTime());
        $ville->setUpdatedAt(new \DateTime());

        $manager->persist($ville);

        //génération de la tournée
        $tournee = new Tournee();
        $tournee->setName('TL01');
        $tournee->setCreatedAt(new \DateTime());
        $tournee->setUpdatedAt(new \DateTime());

        $manager->persist($tournee);

        //génération des libellés et des pdis associés
        for($i = 0; $i < 4 ; $i++){
            $libelle = new Libelle();
            $libelle->setName($faker->streetName());
            $libelle->setCreatedAt(new \DateTime());
            $libelle->setUpdatedAt(new \DateTime());
            $libelle->setVilleId($ville->getId());

            $manager->persist($libelle);

            //pdis dans cette rue
            for($j = 0; $j < mt_rand(4, 15); $j++){
                $pdi = new Pdi();
                
            }
        }


        $manager->flush();
    }
}
