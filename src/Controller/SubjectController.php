<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_USER")
 */

class SubjectController extends AbstractController
{
    /**
        * @Route("/subject", name = "subject_index")
    */
    public function subjectIndexAction()
    {
        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();
        return $this->render(
            'subject/index.html.twig',
            [
                'subjects' => $subjects
            ]
        );
    }

    /**
     * @Route("/subject/Detail/{id}", name = "subject_detail")
     */
    public function subjectDetail($id) {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($subject == null) {
            $this->addFlash('Error', 'subject is not existed');
            return $this->redirectToRoute('subject_index');
        } else {  //$subject != null
            return $this->render(
                'subject/detail.html.twig', 
                [
                    'subject' => $subject
                ]
            );
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/subject/delete/{id}", name = "subject_delete")
     */
    public function subjectDelete ($id) {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        if ($id == null) 
        {
            $this->addFlash('Error', 'subject is not existed');
        }
        
        else
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($subject);
            $manager->flush();
            $this->addFlash('Success', 'subject has been deleted successfully !');   
        }
        return $this->redirectToRoute('subject_index');
    }

    /**
     *@IsGranted("ROLE_ADMIN")
     * @Route("/subject/add", name = "subject_add")
     */
    public function subjectAdd (Request $request) 
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class,$subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            $this->addFlash("Success", "Add new sub subject successfully !");
            return $this->redirectToRoute('subject_index');
        }

        return $this->render(
            "subject/add.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/subject/edit/{id}", name = "subject_edit")
     */
    public function subjectEdit (Request $request, $id) 
    {
        $subject = $this->getDoctrine()->getRepository(subject::class)->find($id);
        $form = $this->createForm(subjectType::class,$subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($subject);
            $manager->flush();

            $this->addFlash("Success", "Edit subject successfully !");
            return $this->redirectToRoute('subject_index');
        }

        return $this->render(
            "subject/edit.html.twig", 
            [
                "form" => $form->createView()
            ]
        );
    }
} 
