<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Home;
use App\Entity\User;

use App\Form\HomeType;
use App\Form\CreateTrickType;
use App\Form\UpdateTrickType;
use App\Form\CommentType;

use App\Controller\CommentController;

use Symfony\Component\HttpFoundation\Request;


class TrickController extends AbstractController
{

  /**
   * @Route("/", name="trick.index")
	 *
   * Affiche la page d'accueil du site
   * Utilise les entités Home et Trick
   */
    public function index()
    {

        $repositoryHome = $this->getDoctrine()->getRepository(Home::class);
		    $repository = $this->getDoctrine()->getRepository(Trick::class);

        return $this->render('trick/index.html.twig', [
			'listAdverts'=> $listAdverts = $repository->findAll(),
      'home'=> $homeAdverts = $repositoryHome->find(1),
		  ]);
    }

    /**
	   * @Route("/homeUser", name="trick.indexUser")
     *
     * Affiche la page d'accueil du site pour un user connecté
     * Prend l'objet Request en argument et utilise les entités Home et Trick
     * Si l'objet Request contient des variables POST, l'accueil est mis à jour.
     */
    public function indexUser(Request $request)
    {

      $repositoryHome = $this->getDoctrine()->getRepository(Home::class);
      $repository = $this->getDoctrine()->getRepository(Trick::class);

      $form = $this->createForm(HomeType::class,
             $repositoryHome->find(1)
        );

      // Si un formulaire est envoyé en méthode POST
      if ($request -> isMethod('POST')) {

          $form-> handleRequest($request);

          if ( $form->isSubmitted() &&  $form->isValid()) {

              $repositoryHomeUpdate = $this->getDoctrine()->getRepository(Home::class);

              $home = $repositoryHomeUpdate->find(1);
              $home -> setContenu ($form['contenu']-> getData());
              $em = $this->getDoctrine()->getManager();
              $em->flush();

              $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
          }
      }

        return $this->render('trick/indexUser.html.twig', [
          'form' => $form->createview(),
          'home'=> $homeAdverts = $repositoryHome->find(1),
          'listAdverts'=> $listAdverts = $repository->findAll(),
    ]);
  }

  /**
   * @Route("/new/", name="trick.new")
   *
   * Affiche le formulaire de création d'un trick
   * Prend l'objet request en argument
   * Si Request contient des données en POST, le trick est ajouté à la BDD
   * Le render est différent en fonction de l'objet Request
   */
    public function new(Request $request)
    {
      $form = $this->createForm(CreateTrickType::class);

    // Si un formulaire est envoyé en méthode POST
      if ($request -> isMethod('POST')) {

        $form-> handleRequest($request);

        if ( $form->isSubmitted() &&  $form->isValid()) {

          $trick = new Trick();
          $trick = $form -> getData();

          $em = $this->getDoctrine()->getManager();
          $em->persist($trick);
          $em->flush();

          return self::showUser($form['titre']-> getData());
        }

      } else {

      // Si le formulaire n'a pas été posté. Appelle le formulaire
      return $this->render('trick/showUserCreate.html.twig', [
        'form' => $form->createview() ,
      ]);
    }
  }

  /**
   * @Route("/view/{$titre}", name="trick.show")
   *
   * Affiche un trick en particulier et l'espace de discussion général
   * Prend un String en argument qui correspond au titre du trick
   * Utilise les entités Trick et Comment
   */
	public function show(String $titre)
    {

		$repository = $this->getDoctrine()->getRepository(Trick::class);
		$repositoryComments = $this->getDoctrine()->getRepository(Comment::class);

        return $this->render('trick/show.html.twig', [
			'advert'=> $listAdvert = $repository->findOneByTitre($titre),
			'listComments'=> $listComments = $repositoryComments->findAll(),
		]);
    }

  /**
   * @Route("/show/{$titre}", name="trick.showUser")
   *
   * Affiche un trick particulier et l'espace de discussion général pour un user connecté
   * Prend un String en argument qui correspond au titre du trick
   * Utilise les entités Trick et Comment
   * Utilise le formulaire HomeType
   */
    public function showUser(String $titre, Request $request)
      {

      $repository = $this->getDoctrine()->getRepository(Trick::class);
      $repositoryComments = $this->getDoctrine()->getRepository(Comment::class);

      
      $form = $this->createForm(CommentType::class, [
          'action' => $this->generateUrl('Comment.create'),
          ]);
      

          return $this->render('trick/showUser.html.twig', [
        'advert'=> $listAdvert = $repository->findOneByTitre($titre),
        'form' => $form->createview(),
        'listComments'=> $listComments = $repositoryComments->findAll(),
      ]);

      }

  /**
   * @Route("/update/{$titre}", name="trick.update")
   *
   * Affiche le formulaire de mise à jour d'un trick
   * Prend un String en argument pour le titre et l'objet Request
   * Si l'objet Request contient des variables POST, l'accueil est mis à jour.
   * Utilise l'entité Trick
   * Utilise le formulaire UpdateTrickType
   */
  	public function update(String $titre, Request $request)
      {

  		$repository = $this->getDoctrine()->getRepository(Trick::class);

      $form = $this->createForm(UpdateTrickType::class,
             $repository->findOneByTitre($titre)
        );

        // Si un formulaire est envoyé en méthode POST
        if ($request -> isMethod('POST')) {

            $form-> handleRequest($request);

            if ( $form->isSubmitted() &&  $form->isValid()) {

                $repositoryUpdate = $this->getDoctrine()->getRepository(Trick::class);

                $trick = $repositoryUpdate->findOneByTitre($titre);
                $trick = $form -> getData();

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            }
        }

          return $this->render('trick/showUserUpdate.html.twig', [
          'form' => $form->createview(),
  			'advert'=> $listAdvert = $repository->findOneByTitre($titre),
  		]);
      }

  /**
   * @Route("/delete/{$titre}", name="trick.delete")
   *
   * Permet la suppression d'un trick de la BDD
   * Prend un string en argument pour le titre
   * Utilise l'entité Trick
   */
  	public function delete(String $titre)
    {

  		$repository = $this->getDoctrine()->getRepository(Trick::class);
      $repositorySupress = $this->getDoctrine()->getRepository(Trick::class);

      $trick = $repositorySupress->findOneByTitre($titre);

      $em = $this->getDoctrine()->getManager();
      $em->remove($trick);
      $em->flush();

      self::indexUser(Request);

    }
}
