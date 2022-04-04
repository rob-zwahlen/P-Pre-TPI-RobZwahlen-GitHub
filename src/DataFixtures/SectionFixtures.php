<?php

namespace App\DataFixtures;

use App\Entity\Section;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sections = [
            'Informatique',
            'Electronique',
            'Mécatronique',
            'Polymécanique',
            'Bois',
            'ECG',
            'Economie',
            'Mathématiques',
            'Anglais',
            'SNAT'
        ];

        for($i = 0; $i < count($sections); ++$i) {

            $section = new Section();
            $section->setName(ucfirst($sections[$i]));
            $manager->persist($section);
        }

        $manager->flush();
    }
}
