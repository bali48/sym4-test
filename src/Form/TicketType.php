<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Repository\DepartmentRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title')
            ->add('Description')
            ->add('Department',EntityType::class,[
                'class' => Department::class,
                'choice_label' => function(Department $department){
                    return sprintf('%s',$department->getName());
                },
                'placeholder' => 'Select Relevant Department'
            ])
//            ->add('Department', EntityType::class, [
//                'class' => Department::class,
//                'query_builder' => function (DepartmentRepository $er) {
//                    return $er->createQueryBuilder('u');
//
//                },
//                'choice_label' => 'Department',
//            ])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
