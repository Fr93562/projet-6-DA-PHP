<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Home;
use App\Entity\User;
use App\Form\HomeType;
use App\Form\CreateTrickType;
use App\Form\UpdateTrickType;
use App\Form\CommentType;

/**
 * Gère les paths de l'entité Trick
 */
class TrickController extends AbstractController
{

  /**
   * @Route("/", name="trick.index")
	 *
   * Affiche la page d'accueil du site
   */
    public function index()
    {

      $repositoryHome = $this->getDoctrine()->getRepository(Home::class);
      $repository = $this->getDoctrine()->getRepository(Trick::class);
      
      $output = $this->render('trick/index.html.twig', [
			  'listAdverts'=> $listAdverts = $repository->findAll(),
        'home'=> $homeAdverts = $repositoryHome->find(1),
      ]);

      if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

        $output = $this->redirectToRoute('trick.indexUser'); 
      }
       return $output;
    }

    /**
	   * @Route("/homeUser", name="trick.indexUser")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * 
     * Affiche la page d'accueil du site pour un user connecté
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
   * @IsGranted("IS_AUTHENTICATED_FULLY")
   * 
   * Affiche le formulaire de création d'un trick
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

      return $this->render('trick/showUserCreate.html.twig', [
        'form' => $form->createview() ,
      ]);
    }
  }

  /**
   * @Route("/view/{$titre}", name="trick.show")
   *
   * Affiche un trick en particulier et l'espace de discussion général
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
   * @IsGranted("IS_AUTHENTICATED_FULLY")
   *
   * Affiche un trick particulier et l'espace de discussion général pour un user connecté
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
   * @IsGranted("IS_AUTHENTICATED_FULLY")
   *
   * Affiche le formulaire de mise à jour d'un trick
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
   * @IsGranted("IS_AUTHENTICATED_FULLY")
   *
   * Supprime un trick de la BDD
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
