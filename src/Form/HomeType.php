<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Controller\TrickController;



class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $content = ['contenu'];

      $builder
              ->add('contenu',     TextType::class)
			        ->add('Mettre à jour',      SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          'attr' => ['id' => 'formHome']


            // Configure your form options here
        ]);
    }
}
