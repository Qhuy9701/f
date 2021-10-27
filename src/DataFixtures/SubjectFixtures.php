<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1 ;$i<15 ;$i++)
        {
            $subject = new Subject();
            $subject->setName("IOT $i");
            $subject->setCode(19051);
            $subject->setPrice(100);
            $manager->persist($subject);
        }
        $manager->flush();
    }
}
