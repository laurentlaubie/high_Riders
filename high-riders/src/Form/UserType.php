<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null , [
                'label' => 'EMail *',
                'attr' => ['placeholder' => 'Saisir votre E-Mail']
            ])
            /* ->add('password', null , [
                'label' => 'Mot de passe',
                'attr' => ['placeholder' => 'Saisir Nouveau mot de passe']
            ]) */
            ->add('firstname', null , [
                'label' => 'Prénom *',
                'attr' => ['placeholder' => 'Saisir Prénom']
            ])
            ->add('lastname', null , [
                'label' => 'Nom *',
                'attr' => ['placeholder' => 'Saisir votre Nom']
            ])
            ->add('pseudo', null , [
                'label' => 'Pseudo',
                'attr' => ['placeholder' => 'Saisir votre Pseudo']
            ])
            ->add('avatar', FileType::class , [
                'label' => 'Avatar',
                'attr' => ['placeholder' => 'Télécharger une photo de profil'],
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
            
            ->add('presentation', null , [
                'label' => 'Description *',
                'attr' => ['placeholder' => 'Saisir un présentation de vous-même']
            ])
            ->add('city', null , [
                'label' => 'Ville *',
                'attr' => ['placeholder' => 'Saisir votre Ville']
            ])
            ->add('departement', null , [
                'label' => 'Departement *',
                'attr' => ['placeholder' => 'Saisir votre département']
            ])
            ->add('equipement', null , [
                'label' => 'Equipement',
                'attr' => ['placeholder' => 'Saisir votre Equipement']
            ])
            ->add('roles',
            ChoiceType::class,
            [
                'choices' => [
                    'ROLE_USER' => "ROLE_USER",
                    'ROLE_EDITOR' => "ROLE_EDITOR",
                    'ROLE_ADMIN' => "ROLE_ADMIN",
                    
                ],
                'multiple' => true,
                // Affichage des éléments sous forme de cases à cocher
                // 'expanded' => true 
            ])
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('categories')
        ;
    

    $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        // ON récupère les données de l'utilisateur que l'on s'apprete
      // à créer ou à éditer
      $user = $event->getData(); // 
      $form = $event->getForm();
     
       // Si on est dans le cas d'une création de compte utilisateur
      // Alors on ajoute le champs password
      if ($user->getId() === null) {
          $form->add('plainPassword', PasswordType::class, [
            'label' => 'Mot de passe',
            'attr' => ['placeholder' => 'Choisir votre mot de passe'],
              // On indique à Symfony que la propriété 'plainPassword'
              // n'est pas liée (mapped) à l'entité User
              'mapped' => false
          ]);
        }
    });
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
