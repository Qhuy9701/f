<?php

namespace App\DataFixtures;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++)
         {
            $course= new Course();
            $course->setName("course $i");
            $course->setStartdate(\DateTime::createFromFormat('Y-m-d','1980-02-11'));
            $course->setEnddate(\DateTime::createFromFormat('Y-m-d','1980-02-11'));
            $manager->persist($course);
        }

        $manager->flush();
    }
}
