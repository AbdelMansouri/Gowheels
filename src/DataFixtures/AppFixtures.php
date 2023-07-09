<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Vehicule;
use App\Entity\Membre;
use App\Entity\Commande;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  private Generator $faker;
  public function __construct()
  {
    $this->faker = Factory::create('fr_FR');
  }
  public function load(ObjectManager $manager): void
  {
    for ($i = 1; $i <= mt_rand(8, 12); $i++) {
      $vehicule = new Vehicule;
      $vehicule->setTitre($this->faker->sentence(1))
        ->setMarque($this->faker->word())
        ->setModele($this->faker->word())
        ->setDescription($this->faker->paragraph(3))
        ->setPhoto($this->randomImage())
        ->setPrixJournalier($this->faker->randomFloat(2, 20, 150))
        ->setDateEnregistrement($this->faker->dateTimeBetween('-3 years'));
      $manager->persist($vehicule);
    }
    $manager->flush();
  }

  private function randomImage(): string
  {
    $randomNumber = mt_rand(1, 9);
    return "{$randomNumber}.png";
  }
}
