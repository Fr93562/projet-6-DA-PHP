<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/*
 * Formulaire de créations de commentaires
 * Utilisé dans CommentController
 */
class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->setAction($this->generateUrl('target_route'))
            //->setMethod('GET')
            ->add('texte',        TextareaType::class)
            ->add('Envoyer',      SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Comment::class,
            'data_class' => null ,
        ]);
    }
}
