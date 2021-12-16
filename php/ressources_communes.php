<?php

/** CONSTANTES. **/

// Paramètres d'accès au serveur MySQL.
const MYSQL_MACHINE_HOTE = "localhost";
const MYSQL_NOM_UTILISATEUR = "user1";
const MYSQL_MOT_DE_PASSE = "hcetylop";
const MYSQL_BASE_DE_DONNEES = "hopital_php";
const MYSQL_CHARSET = "utf8";
const MYSQL_FORMAT_DATE = "Y-m-d";
const MYSQL_PREFIXE_DSN = "mysql:";
const MYSQL_DSN = MYSQL_PREFIXE_DSN."host=".MYSQL_MACHINE_HOTE.";dbname=".MYSQL_BASE_DE_DONNEES.";charset=".MYSQL_CHARSET;

// Jeu de caractères et options de traitement des chaînes.
const HTMLSPECIALCHARS_ENCODING = "UTF-8";
const HTMLSPECIALCHARS_FLAGS = ENT_COMPAT;

// Format français pour les dates : jj/mm/aaaa.
const FORMAT_DATE_AFFICHAGE = "d/m/Y";

// Constante d'année minimum pour la sélection de l'année de naissance du patient.
const ANNEE_MINI = 1900;

/** FONCTIONS **/

// Connexion à un serveur MySQL et à une base de données via PDO.
function PDO_connecte_MySQL() {
    try {
        $bdd = new PDO(MYSQL_DSN, MYSQL_NOM_UTILISATEUR, MYSQL_MOT_DE_PASSE);
    }
    catch (PDOException $e) {
        exit('Erreur de connexion au serveur MySQL : '. $e->getMessage());
    }
    return $bdd;
}

// Fonction de formatage des dates utilisant notre constante d'affichage de date en français.
function formateDate($receivedDate) {
    $date = new DateTime($receivedDate);
    $date_formatee = $date->format(FORMAT_DATE_AFFICHAGE);
    return $date_formatee;
}

?>