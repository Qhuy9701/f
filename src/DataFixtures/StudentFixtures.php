<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++)
         {
            $student = new student();
            $student->setName("student $i");
            $student->setBirthday(\DateTime::createFromFormat('Y-m-d','1980-02-11'));
            $student->setNationality("Vietnam");
            $student->setAvatar("lee-sin-nightbringer.jpg");
            $manager->persist($student);
        }

        $manager->flush();
    }
}
