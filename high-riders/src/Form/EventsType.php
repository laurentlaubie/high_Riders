<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null , [
                'label' => 'Nom de l\'Evenement*',
                'attr' => ['placeholder' => 'Saisir le nom de l\'Evenement']
            ])
            ->add('image', null , [
                'label' => 'Image de l\'Evenement *',
                'attr' => ['placeholder' => 'Ajouter votre image']
            ])
            ->add('description')
            //->add('opening_hours')
            //->add('closed_hours')
            ->add('difficulty')
            //->add('date_event')
            ->add('link')
            ->add('price')
            ->add('accessibility')
            //->add('participation_user')
            ->add('e_like')
            //->add('status')
            ->add('type_event')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('publishedAt')
            //->add('categories')
            //->add('spot')
            //->add('departement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
