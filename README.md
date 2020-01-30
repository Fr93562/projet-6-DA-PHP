# Site communautaire de Snowtrick



![hackList](https://www.abc-of-snowboarding.com/wp-content/uploads/2019/05/Snowboarding-Tricks.jpg)



* Auteur du projet: François M. 	
* Contexte: Parcours Développeur d'application PHP / Symfony chez Openclassrooms  	
* Date: 01/10/2019

* Version: 0.2
* Etat du projet: En cours
* Site web du projet: A venir


-----------------

## Langages:

* HTML / CSS / Jquery

* Librairies: Jquery Bootstrap, ScrollReveal

* PHP / Symfony 4 / MySQL

* Bundles: Alice Bundle

-----------------

## Résumé du projet:


Ce projet est à destination des amateurs de Snowtrick. Le but est de leur proposer un site où ils ont la possibilité de poster des tricks, les mettre à jour ou encore les supprimer. Les utilisateurs du site peuvent aussi discuter avec les autres membres de la communauté via le fil de discussion intégré aux différents tricks.

## Installation du projet:

- Installer le projet dans un dossier
- Récupérer les bundles présents dans composer.json avec la commande composer
- Modifier les éléments de .env pour qu'il corresponde à la base de données utilisé
- Run l'application

## Qualité du code PHP:

### Codacy

![hackList](https://zupimages.net/up/20/04/akjs.png)




## Fonctionnement de l'application:

Ce projet est un site web qui tourne sur le framework Symfony. Il utilise les composants du framework pour la gestion du routeur, du controller et de la vue. 

Les users connectés auront plus de fonctionnalités afin de gérer les tricks, leurs comptes et poster des commentaires.


### Page d'accueil:



![hackList](https://image.noelshack.com/fichiers/2020/01/4/1577976157-accueil.jpg)

- La page d'accueil se décompose en 3 parties: le menu de navigation, l'image avec sa phrase d'accroche et la liste des tricks à consulter.

- Un user connecté a également la possibilité de modifier la phrase d'accroche. Un menu apparait au niveau des tricks afin de proposer un lien pour directement modifier ou supprimer un trick.

### Page d'un trick:

![hackList](https://image.noelshack.com/fichiers/2020/01/5/1578037655-exemple.jpg)

- La page d'un trick donne plusieurs informations sur celui-ci (nom, vidéo, image, date, description..). Le fil de discussion apparait également en bas de la page.


- Un user connecté a également la possibilité de participer au fil de discussion. Un menu apparait également pour proposer des liens pour directement modifier ou supprimer le trick en question.

### Page de connexion:

![hackList](https://image.noelshack.com/fichiers/2020/01/4/1577976345-connexion.jpg)

- La page de connexion donne la possibilité à un visiteur de se connecter au site. Un lien est présent sur la page pour ceux qui souhaitent créer un compte ou encore pour ceux qui ont oublié leur mot de passe.

- Un user connecté aura une page différente avec la possibilité de mettre à jour son compte et de se déconnecter.


## Détails des classes:

Ce projet est construit autour de 3 entités Symfony.

### User / Security:

Cette entité gère les utilisateurs du projet. Plusieurs méthodes sont associés à cet élément.

-----------------

Create(), Read(), Update(), Delete():

Ses méthodes gèrent le CRUD des users et se situent au niveau de userController. Chacune de ses fonctions ont une vue associée (S'inscrire au site, récupérer l'info pour se connecter, mettre à jour son compte et le supprimer).


-----------------

Login(), Logout():

Ses méthodes gèrent la connection de l'utilisateur au site. Chacune de ses fonctions ont une vue associée (page de connexion et bouton de déconnection). La connexion agit sur les variables de session et la déconnection les supprime.

#### Exemple de code:

```php
    /**
     * @Route("/account/login", name="app_login")
     * 
     * Affiche la page de connexion de l'User
     */
     public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
```

### Trick:

Cette entité gère les tricks du projet. Plusieurs méthodes sont associés à cet élément.

-----------------

Create(), Read(), Update(), Delete():

Ses méthodes gèrent le CRUD des tricks et se situent au niveau de trickController. Chacune de ses fonctions ont une vue associée (Rajouter un trick, les consulter, les mettre à jour ou encore en supprimer un).

#### Exemple de code:

```php 

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

  ```

### Comment:

Cette entitée gère les commentaires du projet. Une seule méthode est associée à cet élément.

-----------------

Create():

Cette méthode gère la création d'un commentaire. Elle prends en argument l'user à l'origine du commentaire et son contenu.

-----------------

Remarque:

- La suppression d'un user de la base de données entraine la suppression des commentaires qui lui sont associés.

#### Exemple de code:

```php
...
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    public function getId(): ?int
    {
        return $this->id;
    }
...

```

### Fonctionnement de l'authentification:

Cette application propose deux types d'authentification: anonyme et user authentifié.

L'accès est ainsi restreint en fonction du statut de l'utilisateur.

#### Anonyme:

- Page d'accueil
- Page de Tricks (consultation uniquement + vue sur la discussion générale)
- Page de connexion

#### User authentifié
- Page d'accueil
- Page de Tricks (CRUD + participation à la discussion générale)
- Page du compte utilisateur (Modification des données, déconnexion et suppression du compte)


## Fonctionnement de l'application:

### Consulter les tricks

* La consultation des tricks se fait depuis la barre de navigation située en haut de la page.

* Accueil et la liste des tricks sont sur la même page mais se placent à des endroits différents de la page HTML.


### Se connecter

![hackList](https://image.noelshack.com/fichiers/2020/01/5/1578038568-formulaire.png)

* Cette page s'accède depuis la rubrique mon compte du menu de navigation. Elle donne la possibilité de se connecter si vous êtes déjà inscris ou de créer son compte utilisateur.

### Les droits utilisateurs

![hackList](https://image.noelshack.com/fichiers/2020/01/5/1578038568-trick.jpg)

* Un utilisateur authentifié aura accès à davantage d'actions sur le site, il aura la possibilité de:

- Modifier la phrase d'accoche de la page d'accueil
- Créer, modifier et supprimer un trick
- Participer au topic de discussion avec d'autres membres

### Gérer son compte

![hackList](https://image.noelshack.com/fichiers/2020/01/5/1578038568-compte.png)

* Si l'utilisateur le souhaite, il a la possibilité de gérer son compte en se rendant sur la rubrique "mon compte" de la barre de navigation. Il aura ainsi la possibilité de:

- Modifier certaines informations de son compte
- Sse déconnecter
- Supprimer son compte

-----------------

### Mises à jour:

- Création du projet: 01/10/19
- Mise à jour du projet: 25/10/19
- Rajout du userController, CommentController: 10/11/19
- Création du README: 10/11/19
- Mise à jour du README: 20/11/19
- Mise à jour du README + projet: 03/01/20

