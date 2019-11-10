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

use App\Controller\TrickController;

/*
 * Formulaire de mise à jour des tricks
 * Utilisé dans TrickController
 */
class UpdateTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $content = ['titre'];

        $builder
            ->add('titre',                 TextType::class)
            ->add('lienVideo',             TextType::class)
            ->add('lienImage',             TextType::class)
            ->add('texte',                 TextareaType::class)
            ->add('dateCreation',          DateType::class)
            ->add('dateMiseAJour',         DateType::class)
			      ->add('Modifier ce trick',     SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
