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
            ->add('title')
            ->add('imgupload', FileType::class, [
                'label' => "Choisir une image",
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
            ->add('description')
            ->add('address')
            ->add('city')
            ->add('openingHours')
            ->add('closed_hours')
            ->add('saison_date')
            ->add('numbers_users')
            ->add('average_rating')
            ->add('difficulty')
            ->add('link')
            ->add('price')
            ->add('accessibility')
            ->add('s_like')
            ->add('d_positif')
            ->add('d_negatif')
            ->add('track_number')
            ->add('type_spot')
            ->add('status')
            ->add('categories')
            ->add('departement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
