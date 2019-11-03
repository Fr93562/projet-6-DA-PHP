<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Home;

use App\Form\CreateTrickType;
use App\Form\UpdateTrickType;
use App\Form\HomeType;

use Symfony\Component\HttpFoundation\Request;


class TrickController extends AbstractController
{

  /**
   * @Route("/", name="trick.index")
	 *
   * Méthode qui affiche la page d'accueil du site
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
     * Méthode qui affiche la page d'accueil du site pour un user connecté
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
   * Mméthode qui affiche le formulaire de création d'un trick
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

          $trick -> setTitre ($form['titre']-> getData());
          $trick -> setLienVideo ($form['lienVideo']-> getData());
          $trick -> setLienImage ($form['lienImage']-> getData());
          $trick -> setTexte ($form['texte']-> getData());
          $trick -> setDateCreation ($form['dateCreation']-> getData());
          $trick -> setDateMiseAJour ($form['dateMiseAJour']-> getData());

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
   * Méthode qui affiche un trick en particulier et l'espace de discussion général
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
   * Méthode qui affiche un trick particulier et l'espace de discussion général pour un user connecté
   * Prend un String en argument qui correspond au titre du trick
   * Utilise les entités Trick et Comment
   * Utilise le formulaire HomeType
   */
    public function showUser(String $titre)
      {

      $repository = $this->getDoctrine()->getRepository(Trick::class);
      $repositoryComments = $this->getDoctrine()->getRepository(Comment::class);

          return $this->render('trick/showUser.html.twig', [
        'advert'=> $listAdvert = $repository->findOneByTitre($titre),
        'listComments'=> $listComments = $repositoryComments->findAll(),
      ]);
      }

  /**
   * @Route("/update/{$titre}", name="trick.showUserUpdate")
   *
   * Méthode qui affiche le formulaire de mise à jour d'un trick
   * Prend un String en argument pour le titre et l'objet Request
   * Si l'objet Request contient des variables POST, l'accueil est mis à jour.
   * Utilise l'entité Trick
   * Utilise le formulaire UpdateTrickType
   */
  	public function showUserUpdate(String $titre, Request $request)
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

                $trick -> setTitre ($form['titre']-> getData());
                $trick -> setLienVideo ($form['lienVideo']-> getData());
                $trick -> setLienImage ($form['lienImage']-> getData());
                $trick -> setTexte ($form['texte']-> getData());
                $trick -> setDateCreation ($form['dateCreation']-> getData());
                $trick -> setDateMiseAJour ($form['dateMiseAJour']-> getData());

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
   * @Route("/delete/{$titre}", name="trick.showUserDelete")
   *
   * Méthode qui permet la suppression d'un trick de la BDD
   * Prend un string en argument pour le titre
   * Utilise l'entité Trick
   *
   * Supprime d'abord le trick en BDD
   * Appelle ensuite la méthode indexUser();
   */
  	public function showUserDelete(String $titre)
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
