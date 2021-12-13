<?php
require_once 'ressources_communes.php'
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Recherche d'un patient dans un hopital">

    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <!-- Boostrap -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

    <title>Recherche patient</title>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="recherche_patient.php">
            <img src="../images/logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="logo hopital">
            Hopital
        </a>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                Recherche d'un ou des patients
            </li>
        </ul>
    </nav>
    <div class="container d-flex flex-column h-100">
        <div class="mx-auto my-5 p-3 border">
            <h1>Formulaire de recherche</h1>

            <?php
            
            // Fonction qui renvoie l'année actuelle
            function annee_actuelle(): int {
                $date_actuelle = getdate();
                return $date_actuelle['year'];
            }

            // Création liste déroulante dynamique des motifs
            function form_liste_deroulante_motifs($bdd, $selected_motif = null): void {
                echo "<select class=\"form-control\" name=\"motif\">\n"; // Balise select html pour une liste déroulante
                echo "<option value=\"\">Indifférent</option>\n"; // 1er Option qui vaut indifférent
                
                // Requête SQL pour récupérer les données de la table motif
                $requete = "SELECT code, libelle FROM motifs ORDER BY libelle ASC;";
                try {
                    $resultats = $bdd->query($requete);
                } catch (PDOException $e) {
                    exit("Erreur lors de l'exécution de la requête : " .$e->getMessage());
                }

                foreach ($resultats as $resultat) {
                    $id = htmlspecialchars($resultat['code'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);
                    $libelle = htmlspecialchars($resultat['libelle'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);

                    if ($id == $selected_motif) {
                        echo "<option value=\"$id\" selected=\selected\">$libelle</option>\n";
                    } else {
                        echo "<option value=\"$id\">$libelle</option>\n";
                    }
                }

                unset($resultats); // Destruction du jeu de résultats de la requête
                echo "</select>\n";
            }

            // Création liste déroulante dynamique des pays
            function form_liste_deroulante_pays($bdd, $selected_pays = null): void {
                echo "<select class=\"form-control\" name=\"pays\">\n"; // Balise select html pour une liste déroulante
                echo "<option value=\"\">Indifférent</option>\n"; // 1er Option qui vaut indifférent
                
                // Requête SQL pour récupérer les données de la table motif
                $requete = "SELECT code, libelle FROM pays ORDER BY libelle ASC;";
                try {
                    $resultats = $bdd->query($requete);
                } catch (PDOException $e) {
                    exit("Erreur lors de l'exécution de la requête : " .$e->getMessage());
                }

                foreach ($resultats as $resultat) {
                    $id = htmlspecialchars($resultat['code'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);
                    $libelle = htmlspecialchars($resultat['libelle'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);

                    if ($id == $selected_pays) {
                        echo "<option value=\"$id\" selected=\selected\">$libelle</option>\n";
                    } else {
                        echo "<option value=\"$id\">$libelle</option>\n";
                    }
                }

                unset($resultats); // Destruction du jeu de résultats de la requête
                echo "</select>\n";
            }

            // Création liste déroulante dynamique des années
            function form_liste_deroulante_annee($liste, $annee_min, $annee_max, $selected_year = null): void {
                $liste = htmlspecialchars($liste,HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);
                echo "<select class=\"form-control\" value=\"$liste\">\n"; // Balise select html pour une liste déroulante
                echo " <option value=\"\">Indifférent</option>\n"; // 1er Option qui vaut indifférent
                // Option de selection des années
                for ($annee = $annee_max; $annee >= $annee_min; $annee--) {
                    if ($annee == $selected_year) {
                    echo " <option value='$annee' selected=\"selected\">$annee</option>\n";
                    } else {
                    echo " <option value='$annee'>$annee</option>\n";
                    }
                }
                echo "</select>\n";
            }

            // Création du formulaire de recherche du patient
            function creat_form($bdd): void {
                // Balise formulaire
                echo "<form method=\"post\">\n";

                // Input text pour le nom
                echo "<div class=\"form-group\">";
                echo "<label for='nom_patient'>Nom du patient</label>\n";
                echo '<input class="form-control" type="text" id="nom_patient" name="nom_patient" placeholder="Nom du patient" style="text-transform: uppercase;" value="'. (isset($_POST['nom_patient']) ? htmlspecialchars($_POST['nom_patient'], ENT_COMPAT, "UTF-8") : '') . '">';
                echo "</div>";

                // Liste déroulante motifs
                echo "<div class=\"form-group\">\n";
                echo "<label>Motifs d'admission</label>";
                if (isset($_POST['motif'])) {
                    form_liste_deroulante_motifs($bdd, $_POST['motif']);
                } else {
                    form_liste_deroulante_motifs($bdd);
                }
                echo "</div>\n";

                // Liste déroulante pays
                echo "<div class=\"form-group\">\n";
                echo "<label>Pays de naissance</label>";
                if (isset($_POST['pays'])) {
                    form_liste_deroulante_pays($bdd, $_POST['pays']);
                } else {
                    form_liste_deroulante_pays($bdd);
                }
                echo "</div>\n";

                // Liste déroulante de l'année (minimum, maximum)
                echo "<div class=\"form-group\">\n";
                echo "<label>Année de début de recherche :</label>\n";
                $annee_actuelle = annee_actuelle();
                if (isset($_POST['annee_debut'])) {
                    form_liste_deroulante_annee('annee_debut', ANNEE_MINI, $annee_actuelle, $_POST['annee_debut']);
                } else {
                    form_liste_deroulante_annee('annee_debut', ANNEE_MINI, $annee_actuelle);
                }
                echo "</div>\n";
                echo "<div class=\"form-group\">\n";
                echo "<label>Année de fin de recherche :</label>";
                $annee_actuelle = annee_actuelle();
                if (isset($_POST['annee_fin'])) {
                    form_liste_deroulante_annee('annee_fin', ANNEE_MINI, $annee_actuelle, $_POST['annee_fin']);
                } else {
                    form_liste_deroulante_annee('annee_fin', ANNEE_MINI, $annee_actuelle);
                }
                echo "</div>\n";

                // Bouton submit rechercher
                echo " <div>\n";
                echo " <input class='btn btn-primary' type=\"submit\" name=\"recherche\" value=\"Rechercher\">\n";
                echo " </div>\n";

                echo "</form>\n";
            }

            // Vérification des valeurs pour validation du formulaire
            function valide_form(): string {
                $erreur = "";
                if (!empty($_POST['nom_patient']))
                    if (!ctype_alnum(trim($_POST['nom_patient'])))
                    $erreur .= "<p style='color:red;'>Le nom du patient ne doit pas contenir de caratères spéciaux.</p>\n";


                // Année de début < année de fin
                if (!empty($_POST['annee_debut'])) {
                    if (!empty($_POST['annee_fin'])) {
                        if ($_POST['annee_debut'] > $_POST['annee_fin']) {
                            $erreur .= "<p style='color:red;'>La date de début doit être inférieur à la date de la fin.</p>\n";
                        }
                    }
                }

                return $erreur;
            }

            // Recherche les patients présent dans la base de donnée par rapport à la demande faite dans le formulaire
            function recherche_patients_bdd($bdd) {
                $requete = "SELECT patients.code, nom, prenom
                    FROM patients
                    INNER JOIN pays ON (patients.code_pays = pays.code)
                    INNER JOIN motifs ON (patients.code_motifs = motifs.code)";
                
                if (!empty($_POST['nom_patient'])) {
                    $nom_patient = $bdd->quote('%' . trim($_POST['nom_patient'] . '%'));
                    $requete .= "WHERE nom LIKE $nom_patient";
                }

                if (!empty($_POST['motif'])) {
                    $motif = $bdd->quote(htmlspecialchars_decode($_POST['motif']));
                    $requete .= "AND motifs.code = $motif";
                }

                if (!empty($_POST['pays'])) {
                    $pays = $bdd->quote(htmlspecialchars_decode($_POST['pays']));
                    $requete .= "AND pays.code = $pays ";
                }

                if (!empty($_POST['annee_debut'])) {
                    $annee_debut = $bdd->quote($_POST['annee_debut']);
                    $requete .= "AND YEAR(date_naissance) >= $annee_debut ";
                }

                if (!empty($_POST['annee_fin'])) {
                    $annee_fin = $bdd->quote($_POST['annee_fin']);
                    $requete .= "AND YEAR(date_naissance) <= $annee_fin ";
                }

                $requete .= "ORDER BY nom, prenom ;";

                // Exécution de la requête sur la base de données
                try {
                    $resultats = $bdd->query($requete);
                } catch (PDOException $e) {
                    exit("Erreur lors de l'exécution de la requête : " . $e->getMessage());
                }

                return $resultats;
            }

            function afficher($patients): void {
                echo "<h2 class='my-3'>Liste de résultat</h2>\n";
                
                if ($patients && $patients->rowCount() > 0) {
                    echo "<ul class=\"list-group\" style=\"list-style: none;\">\n";
                    foreach ($patients as $patient) {
                        echo "<li style='margin-bottom:15px'><a class=\"list-group-item list-group-item-action\" href=\"fiche_patient.php?code=" . $patient['code'] . "\">"
                        . strtoupper(htmlspecialchars($patient['nom'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING))
                        . " "
                        . htmlspecialchars($patient['prenom'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING) .
                        "</a></li>\n";
                    }
                    echo "</ul>\n";
                } else {
                    echo "<p>Aucun patient ne correspond à votre recherche.</p>\n";
                }
            }

            $bdd = PDO_connecte_MySQL();
            creat_form($bdd);

            if (isset($_POST['recherche'])) {
                $erreur = valide_form();
                if (empty($erreur)) {
                    $patients = recherche_patients_bdd($bdd);
                    afficher($patients);
                    unset($patients);
                } else {
                    echo $erreur;
                }
            }
            unset($bdd);
            ?>
            </div>
        </div>
    </div>
    
</body>
</html>