<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserLoginType;
use App\Form\UpdateUserType;
use App\Form\UserRegisterType;

/**
 * Gère les paths de l'entité User
 */
class UserController extends AbstractController
{

  /**
   * @Route("/account/", name="user.index")
   *
   * Affiche la page d'accueil de l'User s'il est identifié. Sinon, affiche la page de connexion
   */
    public function index()
    {
        $output = $this->redirectToRoute('app_login');

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $form = $this->createForm(UserLoginType::class);
            return $this->render('user/index.html.twig', [
                'form' => $form->createview() ,
                'controller_name' => 'UserController',
            ]);
        }
        return $output;
    }

    /**
     * @Route("/account/register", name="user.new")
     *
     * Crée un nouvel utilisateur qui sera rajouté en base de données
     */
    public function new(Request $request)
    {
        $form = $this->createForm(UserRegisterType::class);

        if ($request -> isMethod('POST')) {
            $form-> handleRequest($request);

            if ($form->isSubmitted() &&  $form->isValid()) {
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
     * @Route("/account/modify", name="user.update")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * Mets à jour les données de l'user
     */
    public function update(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

        $form = $this->createForm(
            UpdateUserType::class,
            $repository->findOneByUsername($username)
        );

        if ($request -> isMethod('POST')) {
            $form-> handleRequest($request);

            if ($form->isSubmitted() &&  $form->isValid()) {
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
     * @Route("/account/unsubscribe", name="user.delete")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * Supprime un user de la base de données
     */
    public function delete(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

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
