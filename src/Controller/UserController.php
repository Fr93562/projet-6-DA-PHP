<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

use App\Form\UserLoginType;
use App\Form\UpdateUserType;
use App\Form\UserRegisterType;

use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractController
{

  /**
   * @Route("/account/", name="user.index")
   *
   * Affiche la page d'accueil des users
   */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

 /**
  * @Route("/account/login", name="user.login")
  *
  * Sert à la connection des users
  */
	public function login()
    {

		$form = $this->createForm(UserLoginType::class);

        return $this->render('user/login.html.twig', [
			      'form' => $form->createview() ,
            'controller_name' => 'UserController',
        ]);
    }

/**
 * @Route("/account/logout", name="user.logout")
 *
 * Sert à déconnecter l'user du site
 */
	public function logout()
    {
        return $this->render('user/logout.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


/**
 * @Route("/account/register", name="user.new")
 *
 * Sert à créer un nouvel utilisateur qui sera rajouté en base de données
 */
	public function new(Request $request)
    {
		$form = $this->createForm(UserRegisterType::class);

    if ($request -> isMethod('POST')) {

      $form-> handleRequest($request);

      if ( $form->isSubmitted() &&  $form->isValid()) {

        $user = new User();
        $user = $form -> getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
      }
    }

    return $this->render('user/newUser.html.twig', [
			      'form' => $form->createview() ,
            'controller_name' => 'UserController',
        ]);
    }


/**
 * @Route("/account/{$username}/modify", name="user.update")
 *
 * Sert à mettre à jour les données de l'user
 */
	public function update(String $username, Request $request)
    {

    $repository = $this->getDoctrine()->getRepository(User::class);

		$form = $this->createForm(UpdateUserType::class,
           $repository->findOneByUsername($username));

    if ($request -> isMethod('POST')) {

        $form-> handleRequest($request);

        if ( $form->isSubmitted() &&  $form->isValid()) {

            $repositoryUpdate = $this->getDoctrine()->getRepository(User::class);

            $user = $repositoryUpdate->findOneByUsername($username);
            $user = $form -> getData();

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
        }
    }

    return $this->render('user/updateUser.html.twig', [
			      'form' => $form->createview() ,
            'controller_name' => 'UserController',
        ]);
    }

/**
 * @Route("/account/{$username}/delete", name="user.delete")
 *
 * Sert à la suppression d'un user de la base de données
 */
	public function delete(String $username)
    {

      $repository = $this->getDoctrine()->getRepository(User::class);
      $repositorySupress = $this->getDoctrine()->getRepository(User::class);

      $user = $repositorySupress->findOneByUsername($username);

      $em = $this->getDoctrine()->getManager();
      $em->remove($user);
      $em->flush();

      return $this->render('user/deleteUser.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
