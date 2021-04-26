<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilFixtures extends Fixture
{
    public const ADMIN_REFERENCE= "admin";
    public const GERANT_REFERENCE= "gerant";
    public const TRESORIER_REFERENCE= "tresorier";

    public function load(ObjectManager $manager)
    {
        $admin = new Profil();
        $admin->setLibelle(self::ADMIN_REFERENCE);
        $manager->persist($admin);

        $gerant = new Profil();
        $gerant->setLibelle(self::GERANT_REFERENCE);
        $manager->persist($gerant);

        $tresorier = new Profil();
        $tresorier->setLibelle(self::TRESORIER_REFERENCE);
        $manager->persist($tresorier);

        $this->addReference(self::ADMIN_REFERENCE, $admin);
        $this->addReference(self::GERANT_REFERENCE, $gerant);
        $this->addReference(self::TRESORIER_REFERENCE, $tresorier);
        $manager->flush();
    }
}