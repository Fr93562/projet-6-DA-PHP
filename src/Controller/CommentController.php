<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Trick;

use App\Form\CommentType;

use Symfony\Component\HttpFoundation\Request;


class CommentController extends AbstractController
{

/**
  * @Route("/show/{$titre}/post", name="Comment.create")
  * 
  * Crée un nouveau commentaire
  * Retrouve l'user connecté et l'utilise pour créer un commentaire
  * Affiche la page des commentaires par la suite
  */
  public function  create(String $titre, Request $request)
  {

    $repository = $this->getDoctrine()->getRepository(Trick::class);
    $repositoryComments = $this->getDoctrine()->getRepository(Comment::class);

    $form = $this->createForm(CommentType::class);

    if ($request -> isMethod('POST')) {

      $form-> handleRequest($request);

      if ( $form->isSubmitted() &&  $form->isValid()) {

        $test = "test3";
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $userTest = $repositoryUser->findOneByUsername($test);

        $comment = new Comment();
        $comment -> setUsername($userTest);
        $comment -> setTexte ($form['texte'] -> getData());
    
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
      }
    }

    return $this->render('trick/showUser.html.twig', [
      'advert'=> $listAdvert = $repository->findOneByTitre($titre),
      'form' => $form->createview(),
      'listComments'=> $listComments = $repositoryComments->findAll(),
    ]);
  }
}
