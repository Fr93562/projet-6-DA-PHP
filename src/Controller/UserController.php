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
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

		/**
     * @Route("/account/login", name="user.login")
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
     */
	public function logout()
    {
        return $this->render('user/logout.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


	/**
     * @Route("/account/register", name="user.new")
     */
	public function new(Request $request)
    {
		$form = $this->createForm(UserRegisterType::class);

    // Si un formulaire est envoyé en méthode POST
    if ($request -> isMethod('POST')) {

      $form-> handleRequest($request);

      if ( $form->isSubmitted() &&  $form->isValid()) {

        $user = new User();

        $user -> setUsername ($form['username']-> getData());
        $user -> setMail ($form['mail']-> getData());
        $user -> setPassword ($form['password']-> getData());
        $user -> setSalt ("default");
        $user -> setRoles ("User");

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
     * @Route("/account/modify", name="user.update")
     */
	public function update(String $username, Request $request)
    {

		$form = $this->createForm(UpdateUserType::class);

    // Si un formulaire est envoyé en méthode POST
    if ($request -> isMethod('POST')) {

        $form-> handleRequest($request);

        if ( $form->isSubmitted() &&  $form->isValid()) {

            $repositoryUpdate = $this->getDoctrine()->getRepository(User::class);
            $user = $repositoryUpdate->findOneByTitre($username);

            $user -> setUsername ($form['username']-> getData());
            $user -> setMail ($form['mail']-> getData());
            $user -> setPassword ($form['password']-> getData());

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
     * @Route("/account/unsubscribe", name="user.delete")
     */
	public function delete(String $username)
    {

      $repository = $this->getDoctrine()->getRepository(User::class);
      $repositorySupress = $this->getDoctrine()->getRepository(User::class);

      $user = $repositorySupress->findOneByTitre($username);

      $em = $this->getDoctrine()->getManager();
      $em->remove($user);
      $em->flush();

        return $this->render('user/deleteUser.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
