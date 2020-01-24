<?php

namespace App\Form;

use App\Entity\Trick;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/*
 * Formulaire de créations de tricks
 * Utilisé dans TrickController
 */
class CreateTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array('attr' => array( 'placeholder' => 'Titre du trick', 'label' => false)))
            ->add('lienVideo', TextType::class, array('attr' => array('placeholder' => 'Lien vers une vidéo',)))
            ->add('lienImage', TextType::class, array('attr' => array('placeholder' => 'Lien vers une image',)))
            ->add('texte', TextareaType::class , array('attr' => array('placeholder' => 'Texte',)))
            //->add('dateCreation', DateType::class)
            //->add('dateMiseAJour', DateType::class)
            ->add('Rajouter un trick', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
