<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Comment;
use App\Entity\User;


class CommentController extends AbstractController
{

    /**
     * Crée un nouveau commentaire
     * Prend l'user à l'origine de la création sous la forme d'un String
     */
      public function  create(String $user, String $commentContent)
      {

            $commentUser = new User();
            $commentUser -> setUsername($user);

            $comment = new Comment();
            $comment -> setUsername($commentUser);
            $comment -> setTexte($commentContent);

            var_dump($comment);
            //die;
            // ligne qui plante
            $em = $this->getDoctrine()->getManager();

            die;
            $em->persist($comment);
            $em->flush();

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
