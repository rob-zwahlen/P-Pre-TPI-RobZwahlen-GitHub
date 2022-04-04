<?php

namespace App\Form;

use App\Entity\{
    Teacher,
    Section
};

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Man' => 'm',
                    'Woman' => 'w',
                    'Other' => 'o',
                ]
            ])
            ->add('nickname')
            ->add('nickname_origin')
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
            'translation_domain' => 'teachers'
        ]);
    }
}
