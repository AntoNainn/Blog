<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
           // on crée 4 auteurs avec noms et prénoms "aléatoires" en français
           $auteurs = Array();
           for ($i = 0; $i < 4; $i++) {
               $auteurs[$i] = new Auteur();
               $auteurs[$i]->setNom($faker->lastName);
               $auteurs[$i]->setPrenom($faker->firstName);

               $manager->persist($auteurs[$i]);
           }

        $manager->flush();
    }
}
