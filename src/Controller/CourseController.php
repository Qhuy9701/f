<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("ROLE_USER")
 */

class CourseController extends AbstractController
{
    /**
        * @Route("/course", name = "course_index")
    */
    public function courseIndexAction()
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        return $this->render(
            'course/index.html.twig',
            [
                'courses' => $courses
            ]
        );
    }

    /**
     * @Route("/course/Detail/{id}", name = "course_detail")
     */
    public function courseDetail($id) {
        $course = $this->getDoctrine()->getRepository(course::class)->find($id);
        if ($course == null) {
            $this->addFlash('Error', 'course is not existed');
            return $this->redirectToRoute('course_index');
        } else {  //$course != null
            return $this->render(
                'course/detail.html.twig', 
                [
                    'course' => $course
                ]
            );
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/course/delete/{id}", name = "course_delete")
     */
    public function courseDelete ($id) {
        $course = $this->getDoctrine()->getRepository(course::class)->find($id);
        if ($id == null) 
        {
            $this->addFlash('Error', 'course is not existed');
        }
        
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($course);
            $manager->flush();
            $this->addFlash('Success', 'course has been deleted successfully !');   
        }
        return $this->redirectToRoute('course_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/course/add", name = "course_add")
     */
    public function courseAdd (Request $request) 
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class,$course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();

            $this->addFlash("Success", "Add new sub course successfully !");
            return $this->redirectToRoute('course_index');
        }

        return $this->render(
            "course/add.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/course/edit/{id}", name = "course_edit")
     */
    public function courseEdit (Request $request, $id)
    {
        $course = $this->getDoctrine()->getRepository(course::class)->find($id);
        $form = $this->createForm(courseType::class,$course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();

            $this->addFlash("Success", "Edit course successfully !");
            return $this->redirectToRoute('course_index');
        }

        return $this->render(
            "course/edit.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }
} 
