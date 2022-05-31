<?php

namespace App\DataFixtures;

// import de la fabrique (factory) de Faker pour engendrer les valeurs de différents Provider
use Faker\Factory as FakerFactory;

use App\Entity\Artiste;
use App\Entity\CD;
use App\Entity\Documents;
use App\Entity\Emprunts;
use App\Entity\Livres;
use App\Entity\Metier;
use App\Entity\Revues;
use App\Entity\User; 

use App\Repository\ArtisteRepository;
use App\Repository\CDRepository;
use App\Repository\DocumentsRepository;
use App\Repository\EmpruntsRepository;
use App\Repository\LivresRepository;
use App\Repository\MetierRepository;
use App\Repository\RevuesRepository;
use App\Repository\UserRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //Metiers
        for($i = 0; $i < 10; $i++){
            $metier = $this->setMetier();
            $manager->persist($metier);
        }

        $manager->flush();

        //Artistes
        for($i = 0; $i < 10; $i++){
            $artiste = $this->setArtiste($manager);
            $manager->persist($artiste);
        }

        //CD
        for($i = 0; $i < 5; $i++){
            $cd = $this->setCD();
            $manager->persist($cd);
        }

        //Livres
        for($i = 0; $i < 5; $i++){
            $livre = $this->setLivres();
            $manager->persist($livre);
        }

        //Revues
        for($i = 0; $i < 5; $i++){
            $revue = $this->setRevues();
            $manager->persist($revue);
        }

        //User
        for($i = 0; $i < 10; $i++){
            $user = $this->setUser();
            $manager->persist($user);
            
        }
        
        $manager->flush();

        //Emprunts
        for($i = 0; $i < 15; $i++){
            $emprunt = $this->setEmprunt($manager);
            $manager->persist($emprunt);
        }

        $manager->flush();

    }

    private function setMetier(){

        $faker = FakerFactory::create('fr_FR');

        $metier = new Metier;
        $metier->setNom($faker->word());

        return $metier;

    }

    private function setArtiste(ObjectManager $manager){

        $faker = FakerFactory::create('fr_FR');

        $artiste = new Artiste;
        $artiste->setNom($faker->lastName());
        $artiste->setPrenom($faker->firstName());

        $arrayMetiers = $manager->getRepository(Metier::class)->findAll();
        for($a = 0; $a < rand(1,3); $a++){
            $rand_keys = array_rand($arrayMetiers, 1);
            $artiste->addMetier($arrayMetiers[$rand_keys]);
            unset($arrayMetiers[$rand_keys]);
        }

        return $artiste;

    }

    private function setCD(){

        $faker = FakerFactory::create('fr_FR');

        $cd = new CD;
        $cd->setTitre($faker->words(rand(1,5), true));
        $cd->setEtat(rand(1,3));
        $cd->setDescription($faker->paragraph());
        $cd->setNbPistes(rand(1,30));

        return $cd;

    }

    private function setLivres(){

        $faker = FakerFactory::create('fr_FR');

        $livre = new Livres;
        $livre->setTitre($faker->words(rand(1,5), true));
        $livre->setEtat(rand(1,3));
        $livre->setDescription($faker->paragraph());
        $livre->setNbPages(rand(35,1250));

        return $livre;

    }

    private function setRevues(){

        $faker = FakerFactory::create('fr_FR');

        $arrayPeriodicite = array('Journalier', 'Hebdomadaire', 'Mensuel', 'Annuel');

        $revue = new Revues;
        $revue->setTitre($faker->words(rand(1,5), true));
        $revue->setEtat(rand(1,3));
        $revue->setDescription($faker->paragraph());
        $revue->setPeriodicite($arrayPeriodicite[rand(0,3)]);

        return $revue;

    }

    private function setUser(){

        $faker = FakerFactory::create('fr_FR');

        $user = new User;
        $user->setEmail($faker->unique()->freeEmail());
        $user->setPassword($faker->password());
        $user->setPrenom($faker->firstName());
        $user->setNom($faker->lastName());
        $user->setDateInscription($faker->dateTimeBetween('-3 year', 'now')->getTimestamp());

        return $user;
    }

    private function setEmprunt(ObjectManager $manager){

        $faker = FakerFactory::create('fr_FR');

        $emprunt = new Emprunts;
        $emprunt->setDateEmprunt($faker->dateTimeBetween('-3 year', 'now')->getTimestamp());
        $emprunt->setDateRetour($faker->dateTimeBetween('-3 year', '+1 year')->getTimestamp());

        $arrayUsers = $manager->getRepository(User::class)->findAll();
        $rand_keys = array_rand($arrayUsers, 1);
        $emprunt->setIdUser($arrayUsers[$rand_keys]);

        $arrayDocuments = $manager->getRepository(Documents::class)->findAll();
        $rand_keys = array_rand($arrayDocuments, 1);
        $emprunt->setDocument($arrayDocuments[$rand_keys]);

        return $emprunt;

    }

}
