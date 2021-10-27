<?php

namespace App\Form;
use App\Entity\Course;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, 
            [
                'label' => "Student Name",
                'required' => true
            ])
            ->add('birthday', DateType::class,
            [
                'label' => "Birthday",
                'required' => true,
                'widget' => 'single_text'
            ])

            ->add('nationality', ChoiceType::class,
            [
                'label' => "Nationality",
                'required' => true,
                'choices' => [
                    "Vietnam" => "Vietnam",
                    "Singapore" => "Singapore",
                    "Japan" => "Japan",
                    "United States" => "United States",
                    "Canada"=>"Canada",
                    "China"=>"China",
                    "Argentina"=>" Argentina"
                ]
            ])
            ->add('avatar', FileType::class,
            [
                'label' => "Student Image",
                'data_class' => null,
                'required' => is_null($builder->getData()->getAvatar())
            ]
            )

            ->add('course', EntityType::class,
            [
                'label' => "Course",
                'class' => Course::class, 
                'choice_label' => "name",   //show Author name in drop-down list
                'multiple' => true,        //true: select many, false: select one
                'expanded' => false         //true: checkbox   , false: drop-down list
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
