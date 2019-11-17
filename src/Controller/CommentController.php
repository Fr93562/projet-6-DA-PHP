<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Comment;
use App\Entity\User;

use App\Form\CommentType;

use Symfony\Component\HttpFoundation\Request;


class CommentController extends AbstractController
{

    /**
     * @Route("/show/{$titre}/post", name="Comment.create")
     * 
     * Crée un nouveau commentaire
     * Prend l'user à l'origine de la création sous la forme d'un String
     */
      public function  create(String $titre, Request $request)
      {

        echo("test");

        $form = $this->createForm(CreateTrickType::class);

        if ($request -> isMethod('POST')) {

          $form-> handleRequest($request);

          if ( $form->isSubmitted() &&  $form->isValid()) {

              $test = "test2";
              $userComment = new User();
              $userComment -> setUsername($test);

              $comment = new Comment();
              $comment = setPseudo($userComment);
              $comment = setTexte ($form['texte'] -> getData());

    
              $em = $this->getDoctrine()->getManager();

              $em->persist($comment);
              $em->flush();
          }
        }

        return $this->render('trick/indexUser.html.twig', [
          'form' => $form->createview(),
          'home'=> $homeAdverts = $repositoryHome->find(1),
          'listAdverts'=> $listAdverts = $repository->findAll(),
    ]);

      }

    /**
     * Permet la mise à jour de ses commentaires
     * Prend l'user à l'origine de la création sous la forme d'un String
     */
      public function update(String $user, $commentContent)
        {


          $commentRepository = $this->getDoctrine()->getRepository(Trick::class);

          $comment = $commentRepository->findOneByTitre($titre);
          $comment = $form -> getData();

          $em = $this->getDoctrine()->getManager();
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        }

    /**
     * Permet la suppression d'un de ses commentaires
     * Prend l'user à l'origine de la création sous la forme d'un String
     */
      public function delete($id)
      {

        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $comment = $commentRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

      }
}
