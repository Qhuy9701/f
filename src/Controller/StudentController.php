<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */

class StudentController extends AbstractController
{
    /**
        * @Route("/student", name = "student_index")
    */
    public function studentIndexAction()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render(
            'student/index.html.twig',
            [
                'students' => $students
            ]
        );
    }

    /**
     * @Route("/student/Detail/{id}", name = "student_detail")
     */
    public function studentDetail($id) {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'student is not existed');
            return $this->redirectToRoute('student_index');
        } else {  //$student != null
            return $this->render(
                'student/detail.html.twig', 
                [
                    'student' => $student
                ]
            );
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/student/delete/{id}", name = "student_delete")
     */
    public function studentDelete ($id) {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($id == null) 
        {
            $this->addFlash('Error', 'student is not existed');
        }
        
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash('Success', 'student has been deleted successfully !');   
        }
        return $this->redirectToRoute('student_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/student/add", name = "student_add")
     */
    public function studentAdd (Request $request) 
    {
        // $image = $book->getCover();
        // $fileName= uniqid();
        $student = new student();
        $form = $this->createForm(studentType::class,$student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();

            $this->addFlash("Success", "Add new sub student successfully !");
            return $this->redirectToRoute('student_index');
        }

        return $this->render(
            "student/add.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/student/edit/{id}", name = "student_edit")
     */
    public function studentEdit (Request $request, $id) 
    {
        $student = $this->getDoctrine()->getRepository(student::class)->find($id);
        $form = $this->createForm(studentType::class,$student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();

            $this->addFlash("Success", "Edit student successfully !");
            return $this->redirectToRoute('student_index');
        }

        return $this->render(
            "student/edit.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }
} 
