# Devoir 2 - Architecture Client / Serveur
----
## TP Application Web 
## Outil de Gestion des Fiches Patients d'un Hopital 

----
### Sommaire 

1. Information Générale
2. Technologies utilisés 
3. Placer le dossier de l'application dans votre WAMP 
4. Avoir accès à la base de données 
5. Démarrer l'application web avec WAMP 
6. Formulaire de recherche 
7. Fiche patient
8. Ajout de nouveau document
9. Remerciements 
10. Créateurs 

----
### Information Générale

L'installation de cette application web implique que vous ayez des notions dans l'environnement WAMP et que vous l'ayez déjà installé.

Si ce n'est pas le cas, vous pouvez le télécharger à partir du site officiel : <strong> https://www.wampserver.com/ </strong>

----
### Technologies utilisés

Pour la réalisation de ce projet plusieurs technologies ont été utilisées. 

<u>Système d'exploitation :</u>  
    - Windows 10

<u>Front :</u> 
    - HTML 
    - CSS 

<u>Back :</u>  
    - PHP
    - phpMyAdmin
    - Apache 
    - MySQL
    - WampServer

<u>Gestion du projet :</u>  
    - Discord
    - Git
    - GitHub Desktop

----
### Placer le dossier de l'application dans votre WAMP

Lors de l'installation de WampServer, un répertoire <strong> www </strong> a été automatiquement créé. Généralement à l'adresse <strong> C:\wamp64\www\</strong>.

Pour utiliser l'application web, il faut télécharger le dossier parent nommé<strong> Hopital </strong>, disponible sur Git, dans le répertoire <strong> www </strong>. 

----
### Avoir accès à la base de données

Dans le dossier parent <strong>Hopital</strong> ont retrouve un dossier appelé <strong>sql</strong> contenant un fichier nommé <strong>hopital_php.sql</strong>. Il faut importer ce fichier sur phpMyAdmin pour avoir accès aux données nécessaire à l'utilisation de l'application web. 

<u>Pour cela, il faut suivre les étapers suivantes :</u>

Se connecter à <strong>phpMyAdmin</strong> avec un identifiant et un mot de passe. 

Cliquer sur l'onglet <strong>Importer</strong>. 

Cliquer sur le bouton <strong>Choisir un fichier</strong>. 

Repérer sur l'ordinateur le fichier <strong>hopital_php.sql</strong>.

Une fois que le fichier aura été repéré et sélectionné, cliquer sur le bouton <strong>Exécuter</strong> (en bas à droite). 

Pour prendre en compte les paramètres d'accès au serveur MySql, il faut modifier l'identifiant et le mot de passe de la session phpMyAdmin pour que ceux-ci correspondent aux constante <strong>const MYSQL_NOM_UTILISATEUR</strong> et <strong>const MYSQL_MOT_DE_PASSE</strong> present dans le fichier du dossier <strong>php</strong>, <strong>ressources_communes.php</strong>, du projet.

Les données de la structure contenu par le fichier <strong>sql</strong> du projet <strong>Hopital</strong> sont immédiatement disponible pour utilisation dans la base de données. 

----
### Démarrer l'application web avec WAMP

Pour lancer l'application et après avoir allumé WAMP, il faut entrer dans l'URL de votre navigateur "localhost" ce qui va vous permettre d'accéder à la page d'accueil de votre WAMP.

Pour accéder à l'application, il faut entrer <strong>localhost/Hopital/</strong>. 

Vous aller être redirigé vers le lien <strong>http://localhost/Hopital/php/recherche_patient.php</strong>.

L'application s'ouvre sur la page du <strong>Formulaire de recherche</strong>. 

----
### Formulaire de recherche

En appuyant sur l'icon <strong>Hopital</strong> (en haut à gauche, vous réinitialisez le formulaire de recherche.  

Le formulaire de recherche permet à l'utilisateur de trouver un patient en fonction de plusieurs critères tels que : 
    - Le nom du patient
    - Le motif d'admission
    - Le pays
    - La premiere date de l'intervalle de l'année de naissance 
    - La deuxieme date de l'intervalle de l'année de naissance

Le bouton <strong>Rechercher</strong> permet de lancer une recherche en fonction des données saisies et sélectionnées par l'utilisateurs. C'est une recherche multicritères. 

Tous les champs de critères peuvent ne pas être remplis. 

La <strong>Liste de résultat</strong> affiche le nom des patients correspondant à la recherche. 

Pour avoir accès à la fiche du patient, il faut cliquer sur le nom du patient en résultat. 

----
### Fiche patient 

L'icon <strong>Hopital</strong> (en haut à gauche) permet de retourner à la page du formulaire de recherche. Le formulaire de recherche à été réinitialisé.    

La fiche du patient permet d'avoir accès au information du patient tels que : 
    - Le numéro du patient
    - Le nom
    - Le prénom
    - La date de naissance
    - Le pays
    - Le genre
    - Le motif d'admission
    - La date de première admission 
    - Le numéro de sécurité sociale

La partie <strong>Options pour documents :</strong> donne accès à plusieurs fonctionnalités notamment : 
    - L'ajout de nouveau document, avec le lien <strong>Veuillez ajouter un nouveau document.</strong> 
    - La consultation de document déjà présent sur l'application 
    - Le téléchargement de document déjà présent sur l'application
    - L'envoi d'un mail

Le lien <strong>Retour</strong> permet permet de retourner à la page du formulaire de recherche. Le formulaire de recherche à été réinitialisé.    

----
### Ajout de nouveau document 

Le lien <strong>Veuillez ajouter un nouveau document.</strong> de la page de la fiche du patient, permet d'avoir accès à la page <strong>Nouveau document du patient</strong>. 

Cette page indique que la <strong>Taille maximum du fichier :</strong> est de <strong>10Mo</strong> et que les <strong>Fichiers autorisés :</strong> doivent être d'extensions <strong>txt, pdf, jpg, jpeg, png.</strong>.

Elle permet d'<strong>Ajouter un fichier pour le patient</strong>. Pour cela il faut sélectionner un fichier dans l'ordinateur en cliquant sur <strong>Sélectionner un fichier</strong> ou <strong>Browse</strong>.

Après avoir sélectionnez le fichier, appuyez sur le bouton <strong>Enregistrer</strong>. 

Par la suite, vous êtes rédirigez vers la page de la fiche du patient. 

Vous pouvez constaté, dans la partie <strong>Options pour document :</strong>, que le document à bien été enregistré. 

----
### Remerciements 

Merci d'avoir prit le temps de lire ce README. EN espèrant qu'il vous aura été utile. 

----
### Créateurs

Projet réalisé par les winner Dimitri TRAN DUC HUY & Mathilde NYIKEINE.
Etudiants en Première année de Master MIAGE à l'Université de la Nouvelle-Calédonie.
Promotion 2021.

----