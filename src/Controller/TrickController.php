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
use Service\Tools\Slugger;

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
    public function index(Request $request)
    {
        $repositoryHome = $this->getDoctrine()->getRepository(Home::class);
        $repository = $this->getDoctrine()->getRepository(Trick::class);
        $trickRequest = $request->query->get('trick');
        $trickTotalNumber = count($repository->findAll());

        if ($trickRequest == null) {

          $trickRender = 1;
        } else {

          $trickRender = $trickRequest + 1;
          $trickRequest = ($trickRequest + 1 ) * 10;
        }

        $listTricks = $repository->findBy(array(), null, $trickRequest, null);

        foreach ($listTricks as $advert){
        
          $advert->setSlug($advert->getTitre());
        }
    
        $output = $this->render('trick/index.html.twig', [
              'listAdverts'=> $listTricks,
              'home'=> $homeAdverts = $repositoryHome->find(1),
              'listTrick'=> $trickRender,
              'number'=>$trickTotalNumber,
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
        $trickRequest = $request->query->get('trick');
        $trickTotalNumber = count($repository->findAll());

        if ($trickRequest == null) {

          $trickRender = 1;
        } else {

          $trickRender = $trickRequest + 1;
          $trickRequest = ($trickRequest + 1 ) * 10;
        }

        $listTricks = $repository->findBy(array(), null, $trickRequest, null);

        foreach ($listTricks as $advert){
        
          $advert->setSlug($advert->getTitre());
        }

        $form = $this->createForm(
          HomeType::class,
          $repositoryHome->find(1)
      );

        // Si un formulaire est envoyé en méthode POST
        if ($request -> isMethod('POST')) {
            $form-> handleRequest($request);

            if ($form->isSubmitted() &&  $form->isValid()) {
                $repositoryHomeUpdate = $this->getDoctrine()->getRepository(Home::class);

                $home = $repositoryHomeUpdate->find(1);
                $home -> setContenu($form['contenu']-> getData());
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            }
        }

        return $this->render('trick/indexUser.html.twig', [
        'form' => $form->createview(),
        'home'=> $homeAdverts = $repositoryHome->find(1),
        'listAdverts'=> $listTricks,
        'listTrick'=> $trickRender,
        'number'=>$trickTotalNumber,
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

            if ($form->isSubmitted() &&  $form->isValid()) {
                
                $trick = new Trick();
                //$listImage = explode(',', "dataList" );
                //$listVideo = explode(',', "dataList" );
                $trick = $form -> getData();
                $trick->setDateCreation(new \DateTime());

                $em = $this->getDoctrine()->getManager();
                $em->persist($trick);
                $em->flush();

                return self::showUser($form['titre']-> getData(), $request);
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
    public function show(String $titre, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Trick::class);
        $repositoryComments = $this->getDoctrine()->getRepository(Comment::class);
        $commentRequest = $request->query->get('comment');
        $trickTotalNumber = count($repositoryComments->findAll());

        if ($commentRequest == null) {

          $commentRender = 1;
          $commentRequest = 5;
        } else {

          $commentRender = $commentRequest + 1;
          $commentRequest = ($commentRequest + 1 ) * 5;
        }
        $listComments = $repositoryComments->findBy(array(), null, $commentRequest, null);


        $listAdvert = $repository->findOneByTitre(Slugger::noSlugify($titre));
        $listAdvert->setSlug($listAdvert->getTitre());
        $listAdvert->setLienImages(implode( ',', $listAdvert->getLienImage()));
        $listAdvert->setLienVideos(implode( ',', $listAdvert->getLienVideo()));

        return $this->render('trick/show.html.twig', [
            'advert'=> $listAdvert,
            'listComments'=> $listComments,
            'number'=> $commentRender,
            'totalComment' => $trickTotalNumber,
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

        $listAdvert = $repository->findOneByTitre(Slugger::noSlugify($titre));
        $listAdvert->setSlug($listAdvert->getTitre());
        $listAdvert->setLienImages(implode( ',', $listAdvert->getLienImage()));
        $listAdvert->setLienVideos(implode( ',', $listAdvert->getLienVideo()));
        $commentRequest = $request->query->get('comment');
        $trickTotalNumber = count($repositoryComments->findAll());

        if ($commentRequest == null) {

          $commentRender = 1;
          $commentRequest = 5;
        } else {

          $commentRender = $commentRequest + 1;
          $commentRequest = ($commentRequest + 1 ) * 5;
        }
        $listComments = $repositoryComments->findBy(array(), null, $commentRequest, null);
      
        $form = $this->createForm(CommentType::class, [
          'action' => $this->generateUrl('Comment.create'),
          ]);
      
        return $this->render('trick/showUser.html.twig', [
        'advert'=> $listAdvert,
        'form' => $form->createview(),
        'listComments'=> $listComments = $repositoryComments->findAll(),
        'number'=> $commentRender,
        'totalComment' => $trickTotalNumber,
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
        $trickFound = $repository->findOneByTitre(Slugger::noSlugify($titre));

        implode( ',', $trickFound->getLienImage());
        $trickFound->setLienImages(implode( ',', $trickFound->getLienImage()));
        $trickFound->setLienVideos(implode( ',', $trickFound->getLienVideo()));

        $form = $this->createForm( UpdateTrickType::class, $trickFound);

        // Si un formulaire est envoyé en méthode POST
        if ($request -> isMethod('POST')) {
            $form-> handleRequest($request);

            if ($form->isSubmitted() &&  $form->isValid()) {
                $repositoryUpdate = $this->getDoctrine()->getRepository(Trick::class);

                $trick = $repositoryUpdate->findOneByTitre(Slugger::noSlugify($titre));
                var_dump($form -> getData()->getTitre());

                $trick = $form -> getData();
                $trick->setDateMiseAJour(new \DateTime());
                $trick->setLienImage(explode(',', $trick->getLienImages()));
                $trick->setLienVideo(explode(',', $trick->getLienVideos()));

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

        $trick = $repositorySupress->findOneByTitre(Slugger::noSlugify($titre));

        $em = $this->getDoctrine()->getManager();
        $em->remove($trick);
        $em->flush();

        //self::index();
        return $this->redirectToRoute('trick.index');
    }
}
