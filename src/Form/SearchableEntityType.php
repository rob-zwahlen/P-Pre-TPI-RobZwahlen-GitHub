<?php

namespace App\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchableEntityType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(

            function(Collection $value): array 
            {
                return $value->map(fn($d) => (string)$d->getId())->toArray();
            },

            function(?array $ids) use ($options): Collection 
            {
                if(empty($ids)) {
                    return new ArrayCollection([]);
                }

                return new ArrayCollection(
                    $this->em->getRepository($options['class'])->findBy(['id' => $ids])
                );
            }
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['expanded'] = false; // On ne veut pas de checkbox
        $view->vars['placeholder'] = null;
        $view->vars['placeholder_in_choices'] = false;
        $view->vars['multiple'] = true; // On précise que l'on veut quelque chose de multiple pour une relation ManyToMany
        $view->vars['preferred_choices'] = [];
        $view->vars['choices'] = $this->choices(new ArrayCollection($this->em->getRepository($options['class'])->findAll()));
        $view->vars['choice_translation_domain'] = false; // Traduction des labels
        $view->vars['full_name'] .= '[]';
        $view->vars['attr']['data-remote'] = $options['search'];
        $view->vars['attr']['data-value'] = $options['value_property'];
        $view->vars['attr']['data-label'] = $options['label_property'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'multiple' => true,
            'search' => '/search',
            'value_property' => 'id',
            'label_property' => 'name'
        ]);

        $resolver->setRequired('class');
    }

    public function getBlockPrefix(): string
    {
        return 'choice';
    }

    private function choices(Collection $value): array
    {
        return $value->map(fn ($d) => new ChoiceView($d, (string)$d->getId(), (string)$d))->toArray();
    }
}