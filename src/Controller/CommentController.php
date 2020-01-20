<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Trick;
use App\Form\CommentType;

/**
 * Gère les paths de Comment
 */
class CommentController extends AbstractController
{

/**
  * @Route("/show//post", name="Comment.create")
  * @IsGranted("IS_AUTHENTICATED_FULLY")

  * Crée un nouveau commentaire
  */
  public function  create(Request $request, AuthenticationUtils $authenticationUtils)
  {

    $request = Request::createFromGlobals();
    $titre = $request->query->get('titre');
    $form = $this->createForm(CommentType::class);

    if ($request -> isMethod('POST')) {

      $form-> handleRequest($request);

      if ( $form->isSubmitted() &&  $form->isValid()) {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $userTest = $repositoryUser->findOneByUsername($lastUsername);

        $comment = new Comment();
        $comment -> setUsername($userTest);
        $comment -> setTexte ($form['texte'] -> getData());
    
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
      }
    }
    return $this->redirectToRoute('trick.showUser');
  }
}
