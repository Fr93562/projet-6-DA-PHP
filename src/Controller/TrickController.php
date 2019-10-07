<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use App\Repository\TrickRepository;

class TrickController extends AbstractController
{
    /**
	 * @Route("/", name="trick.index")
     */
    public function index()
    {
		
	//	$repository = $this->getDoctrine()->getRepository(TrickRepository::class);
		
        return $this->render('trick/index.html.twig');
    }
	
	
	/**
     * @Route("/show", name="trick.show")
     */
	
	// Méthode à améliorer
	
	public function show()
    {
        return $this->render('trick/show.html.twig');
    }
	
	/**
	 * @Route("/newTrick/", name="trick.new")
     */
    public function new()
    {
        return $this->render('trick/index.html.twig');
    }
	
	/**
	 * @Route("/updateTrick/", name="trick.update")
     */
    public function update()
    {
        return $this->render('trick/index.html.twig');
    }
	
}
