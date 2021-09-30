<?php

namespace App\Form;

use App\Entity\Spot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class SpotsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null , [
                'label' => 'Nom du Spot *',
                'attr' => ['placeholder' => 'Saisir le nom du spot']
            ])
            ->add('image', FileType::class, [
                'label' => 'Image du Spot *',
                'attr' => ['placeholder' => 'Ajouter votre image'],
                'mapped' => false,
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
                 ],
             ])
            ->add('description', null , [
                'label' => 'Description du Spot *',
                'attr' => ['placeholder' => 'Ajouter une description']
            ])
            ->add('address')
            ->add('city', null , [
                'label' => 'Ville du Spot *',
                'attr' => ['placeholder' => 'Ajouter la ville']
            ])
            ->add('openingHours')
            ->add('closed_hours')
            ->add('saison_date')
            ->add('numbers_users')
            ->add('average_rating')
            ->add('Latitude')
            ->add('Longitude')
            ->add('difficulty')
            ->add('link')
            ->add('price')
            ->add('accessibility')
            ->add('s_like')
            ->add('d_positif')
            ->add('d_negatif')
            ->add('track_number')
            ->add('type_spot', null , [
                'label' => 'Type de Spot *',
                'attr' => ['placeholder' => 'Ajouter le type']
            ])
            //->add('status')
            ->add('categories')
            ->add('departement')
            //->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
