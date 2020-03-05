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

        $pdi_ordre = 1;
        //génération des libellés et des pdis associés
        for($i = 0; $i < 4 ; $i++){
            $libelle = new Libelle();
            $libelle->setName($faker->streetName());
            $libelle->setCreatedAt(new \DateTime());
            $libelle->setUpdatedAt(new \DateTime());
            $libelle->setVilleId($ville);

            $manager->persist($libelle);

            //pdis dans cette rue
            for($j = 0; $j < mt_rand(4, 15); $j++){
                $pdi = new Pdi();
                $pdi->setNumero($faker->numberBetween(1, 50));
                $pdi->setClientName($faker->lastName());
                $pdi->setIsDepot(False);
                $pdi->setIsReex(False);
                $pdi->setCreatedAt(new \DateTime());
                $pdi->setUpdatedAt(new \DateTime());
                $pdi->setTourneeId($tournee);
                $pdi->setLibelleId($libelle);
                $pdi->setOrdre($pdi_ordre);
                $pdi_ordre++;
                $pdi->setFormat('1x1');

                $manager->persist($pdi);
            }
        }


        $manager->flush();
    }
}
