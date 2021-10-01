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
            ->add('address', null , [
                'label' => 'Adresse du Spot ',
                'attr' => ['placeholder' => 'Ajouter une rue']
            ])
            ->add('city', null , [
                'label' => 'Ville du Spot *',
                'attr' => ['placeholder' => 'Ajouter la ville']
            ])
            ->add('opening_hours', null , [
                'label' => 'Horaire d\'ouverture du Spot',
                'attr' => ['placeholder' => 'Ajouter l\'horaire']
            ])
            ->add('closed_hours', null , [
                'label' => 'Horaire de fermeture du Spot',
                'attr' => ['placeholder' => 'Ajouter l\'horaire']
            ])
            ->add('saison_date', null , [
                'label' => 'Ouverture du Spot',
                'attr' => ['placeholder' => 'Ajouter les dates']
            ])
            ->add('numbers_users', null , [
                'label' => 'Jauge de Riders Possible sur le site ',
                'attr' => ['placeholder' => 'Ajouter le nombre']
            ])
            ->add('average_rating', null , [
                'label' => 'Note du spot (sur 5)',
                'attr' => ['placeholder' => 'Ajouter la note']
            ])
            //->add('Latitude')
            //->add('Longitude')
            ->add('difficulty', null , [
                'label' => 'Difficulté du Spot (sur 5)',
                'attr' => ['placeholder' => 'Ajouter la note']
            ])
            ->add('link', null , [
                'label' => 'Lien du site du Spot',
                'attr' => ['placeholder' => 'Ajouter un lien https...']
            ])
            ->add('price', null , [
                'label' => 'Tarif d\'entrée du Spot',
                'attr' => ['placeholder' => 'Ajouter un tarif']
            ])
            ->add('accessibility', null , [
                'label' => 'Acces au Spot',
                'attr' => ['placeholder' => 'Ajouter un descriptif d\'acces']
            ])
            /* ->add('s_like', null , [
                'label' => 'Nombre de Like',
                'attr' => ['placeholder' => 'Ajouter le nombre de like']
            ]) */
            ->add('d_positif', null , [
                'label' => 'Dénivelé Positif',
                'attr' => ['placeholder' => 'Ajouter le dénivelé']
            ])
            ->add('d_negatif', null , [
                'label' => 'Dénivelé Negatif',
                'attr' => ['placeholder' => 'Ajouter le dénivelé']
            ])
            ->add('track_number', null , [
                'label' => 'Nombre de pistes',
                'attr' => ['placeholder' => 'Ajouter le nombre de pistes disponibles']
            ])
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
