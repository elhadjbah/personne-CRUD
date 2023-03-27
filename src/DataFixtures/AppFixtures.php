<?php

namespace App\DataFixtures;
use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=50;$i++){
            $personne = new Personne();
            $personne->setNom('nom #'.$i);
            $personne->setPrenom('prenom '.$i);
            //$personne->setDatenaissance();
            $personne->setEmail('abc@u.com'.$i);
            $personne->setMotdepasse('Motdepass'.$i);
            $manager->persist($personne);
        }

        $manager->flush();
    }
}


