<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/*
 * Formulaire de créations d'un user
 * Utilisé dans Usercontroller
 */
class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username',             TextType::class , array('attr' => array('placeholder' => 'votre pseudo',)))
                ->add('mail',                 TextType::class , array('attr' => array('placeholder' => 'votre mail',)))
			          ->add('password',             TextType::class, array('attr' => array('placeholder' => 'votre mot de mot de passe',)))
			          ->add('Créer mon compte',     SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
