<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('email')
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
            // ->add('password')
            ->add('pseudo')
            ->add('avatar')
            ->add('firstname')
            ->add('lastname')
            ->add('presentation')
            ->add('city')
            ->add('departement')
            ->add('equipement')
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
