<?php

namespace App\DataFixtures;

use App\Entity\Epargne;
use App\Entity\Gerant;
use App\Entity\Tontine;
use App\Entity\Tour;
use App\Entity\Tresorier;
use App\Entity\User;
use Faker;
use Lcobucci\JWT\Claim\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager){
        
        $faker=Faker\Factory::create('fr_FR');

        $tab= ['admin', 'gerant', 'tresorier'];
        //foreach($tab as $t){
            $tontine=new Tontine();
            $tour=new Tour();
            $tontine->setNom("Callebasse");
            $tontine->setDateCreation(new \DateTime('now'));
            $tontine->setDateFin(new \DateTime('now'));
            $tontine->setSession("Premiere Session");
            $tontine->setArchivage(0);
            $tour->setTontine($tontine);
            for($i=0; $i<count($tab); $i++){
                
                if($tab[$i]=="admin"){
                    $user=new User();
                    $user->setProfil($this->getReference(ProfilFixtures::ADMIN_REFERENCE));
                    $user->setRoles(['ROLE_ADMIN']);
                }

                if($tab[$i]=="gerant"){
                    $user=new Gerant();
                    $user->setProfil($this->getReference(ProfilFixtures::GERANT_REFERENCE));
                    $user->setRoles(['ROLE_GERANT']);
                }

                if($tab[$i]=="tresorier"){
                    $user=new Tresorier();
                    $user->setProfil($this->getReference(ProfilFixtures::TRESORIER_REFERENCE));
                    $user->setRoles(['ROLE_TRESORIER']);
                }

                $user->setPrenom($faker->firstName());
                $user->setNom($faker->lastName);
                $user->setEmail($faker->email);
                $user->setTelephone($faker->phoneNumber);
                $user->addTontine($tontine);
                $password = $this->passwordEncoder->encodePassword($user,'password');
                $user->setArchivage(0);
                $user->setPassword($password);
                $user->setGenre('Feminin');
                $user->setStatus('actif');
                $user->setCni($faker->numberBetween($min = 1000000000000, $max = 9000000000000));
                $user->setAvatar('image.png');
                $user->setAdresse($faker->address);

                $epargne=new Epargne();
                $epargne->setMontant("2000 fr");
                $epargne->setInteret("000 fr");
                $epargne->setDateEpargne(new \DateTime('now'));
                $epargne->setArchivage(0);
                $epargne->addTour($tour);
                //$epargne->addUser($user);
                //$tontine->setUser($user);
                //$epargne->setTontine($tontine);

                $manager->persist($epargne);
                $manager->persist($user);
                $manager->persist($tontine);
            }
           
           
           
           
           
           
           
           
        //}
        $manager->flush();
    }
}