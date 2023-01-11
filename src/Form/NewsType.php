<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('subtitle')
            ->add('teaser')
            ->add('bodytext')
            ->add('createAt')
            ->add('modifyAt')
            ->add('hide')
            ->add('deleted')
            ->add('isEvent')
            ->add('dailyEvent')
            ->add('eventStart')
            ->add('eventEnde')
            ->add('bild')
            ->add('bilder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
