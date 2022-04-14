<?php

namespace App\Form;

use App\Entity\{
    Teacher,
    Section,
    Discipline
};

use App\Form\SearchableEntityType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TeacherType extends AbstractType
{
    public function __construct(private UrlGeneratorInterface $url) {}

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
            ->add('disciplines', SearchableEntityType::class, [
                'class' => Discipline::class,
                'search' => $this->url->generate('disciplines'),
                'label_property' => 'name',
                'value_property' => 'id',
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
