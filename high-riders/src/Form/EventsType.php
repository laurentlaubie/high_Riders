<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null , [
                'label' => 'Nom de l\'Evenement *',
                'attr' => ['placeholder' => 'Saisir le nom de l\'Evenement']
            ])
            ->add('image', null, [
                'label' => 'Image de l\'Evenement *',
                'attr' => ['placeholder' => 'Ajouter votre image'],
                ])
                
               //test for upload imge
                //FileType::class
                   /*  'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/png',
                                'image/jpeg'
                            ],
                            'mimeTypesMessage' => 'Merci de ne choisir que des fichiers .png et .jpeg',
                        ]) 
                    ], */
            
            ->add('description', null , [
                'label' => 'Description de l\'Evenement *',
                'attr' => ['placeholder' => 'Ajouter votre description']
            ])
            ->add('opening_hours', null , [
                'label' => 'Horaire d\'ouverture de l\'Evenement',
                'attr' => ['placeholder' => 'Ajouter l\'horaire']
            ])
            ->add('closed_hours', null , [
                'label' => 'Horaire de fermeture de l\'Evenement',
                'attr' => ['placeholder' => 'Ajouter l\'horaire']
            ])
            ->add('difficulty')
            ->add('date_event', null , [
                'label' => 'Date de l\'Evenement *',
                'attr' => ['placeholder' => 'Ajouter une date']
            ])
            ->add('link', null , [
                'label' => 'Lien du site de l\'Evenement',
                'attr' => ['placeholder' => 'Ajouter un lien https...']
            ])
            ->add('price', null , [
                'label' => 'Tarif de l\'Evenement',
                'attr' => ['placeholder' => 'Ajouter un tarif']
            ])
            ->add('accessibility', null , [
                'label' => 'Acces à l\'Evenement *',
                'attr' => ['placeholder' => 'Ajouter un descriptif d\'acces']
            ])
            //->add('participation_user')
            ->add('e_like')
            //->add('status')
            ->add('type_event', null , [
                'label' => 'Type de l\'Evenement *',
                'attr' => ['placeholder' => 'Ajouter un type d\'Evenement']
            ])
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
