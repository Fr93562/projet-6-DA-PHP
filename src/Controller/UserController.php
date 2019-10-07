<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserLoginType;
use App\Form\UpdateUserType;
use App\Form\UserRegisterType;

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
     * @Route("/account/register", name="user.newUser")
     */
	public function newUser()
    {
		$form = $this->createForm(UserRegisterType::class);
		
        return $this->render('user/newUser.html.twig', [
			'form' => $form->createview() ,
            'controller_name' => 'UserController',
        ]);
    }
	
	
	/**
     * @Route("/account/modify", name="user.updateUser")
     */
	public function updateUser()
    {
		
		$form = $this->createForm(UpdateUserType::class);
		
        return $this->render('user/updateUser.html.twig', [
			'form' => $form->createview() ,
            'controller_name' => 'UserController',
        ]);
    }
	
	/**
     * @Route("/account/unsubscribe", name="user.deleteUser")
     */
	public function deleteUser()
    {
		
        return $this->render('user/deleteUser.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
