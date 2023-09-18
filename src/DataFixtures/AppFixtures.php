<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Article;
use App\Entity\Avis;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $Categorie = new Categorie();
            $Categorie->setLibelle($faker->word());
            $manager->persist($Categorie);
        }
        for ($i = 0; $i < 5; $i++) {
            $Utilisateur = new Utilisateur();
            $Utilisateur->setPseudo($faker->name());
            $Utilisateur->setMdp($faker->password());
            $Utilisateur->setMail($faker->email());
            $manager->persist($Utilisateur);
        }
        // for ($i = 0; $i < 5; $i++) {
        //     $Article = new Article();
        //     $Article->setTitre($faker->sentence());
        //     $Article->setContenu($faker->paragrah());
        //     $Article->setDate($faker->DateTime());
        //     $manager->persist($Article);
        // }

        $manager->flush();
    }
}
