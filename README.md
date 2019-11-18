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
* Symfony 4.3

* Librairies: Jquery Bootstrap, ScrollReveal

-----------------

## Résumé du projet:


Ce projet est à destination des amateurs de Snowtrick. Le but est de leur proposer un site où ils ont la possibilité de poster des tricks, les mettre à jour ou encore les supprimer. Les utilisateurs du site peuvent aussi discuter avec les autres membres de la communauté via le fil de discussion intégré aux différents tricks.


## Installation du projet:

/

## Fonctionnement de l'application:

Ce projet est un site web qui tourne sur le framework Symfony. Il utilise les composants du framework pour la gestion du routeur, du controller et de la vue. 

Les users connectés auront plus de fonctionnalités afin de gérer les tricks, leurs comptes et poster des commentaires.


### Page d'accueil:

- La page d'accueil se décompose en 3 parties: le menu de navigation, l'image avec sa phrase d'accroche et la liste des tricks à consulter.

- Un user connecté a également la possibilité de modifier la phrase d'accroche. Un menu apparait au niveau des tricks afin de proposer un lien pour directement modifier ou supprimer un trick.

### Page d'un trick:

- La page d'un trick donne plusieurs informations sur celui-ci (nom, vidéo, image, date, description..). Le fil de discussion apparait également en bas de la page.


- Un user connecté a également la possibilité de participer au fil de discussion. Un menu apparait également pour proposer des liens pour directement modifier ou supprimer le trick en question.

### Page de connexion:

- La page de connexion donne la possibilité à un visiteur de se connecter au site. Un lien est présent sur la page pour ceux qui souhaitent créer un compte ou encore pour ceux qui ont oublié leur mot de passe.

- Un user connecté aura une page différente avec la possibilité de mettre à jour son compte et de se déconnecter.


## Détails des classes:

Ce projet est construit autour de 3 entités Symfony.

### User :

Cette entité gère les utilisateurs du projet. Plusieurs méthodes sont associés à cet élément.

-----------------

Create(), Read(), Update(), Delete():

Ses méthodes gèrent le CRUD des users et se situent au niveau de userController. Chacune de ses fonctions ont une vue associée (S'inscrire au site, récupérer l'info pour se connecter, mettre à jour son compte et le supprimer).

-----------------

Login(), Logout():

Ses méthodes gèrent la connection de l'utilisateur au site. Chacune de ses fonctions ont une vue associée (page de connexion et bouton de déconnection). La connexion agit sur les variables de session et la déconnection les supprime.

-----------------

Auth():

Cette méthode gère l'authentification et donne certains droits à l'utilisateur connecté.


### Trick:

Cette entité gère les tricks du projet. Plusieurs méthodes sont associés à cet élément.

-----------------

Create(), Read(), Update(), Delete():

Ses méthodes gèrent le CRUD des tricks et se situent au niveau de trickController. Chacune de ses fonctions ont une vue associée (Rajouter un trick, les consulter, les mettre à jour ou encore en supprimer un).


### Comment:

Cette entitée gère les commentaires du projet. Une seule méthode est associée à cet élément.

-----------------

Create():

Cette méthode gère la création d'un commentaire. Elle prends en argument l'user à l'origine du commentaire et son contenu.

-----------------

Remarque:

- La suppression d'un user de la base de données entraine la suppression des commentaires qui lui sont associés.


-----------------

### Mises à jour:

- Création du projet: 01/10/19
- Mise à jour du projet: 25/10/19
- Rajout du userController, CommentController: 10/11/19
- Création du README: 10/11/19
- Mise à jour du README: 20/11/19

