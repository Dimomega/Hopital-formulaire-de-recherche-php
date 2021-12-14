<?php
session_start();
require_once 'ressources_communes.php'
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fiche d'un patient dans un hopital">

    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <!-- Boostrap -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

    <title>Fiche patient</title>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="recherche_patient.php">
            <img src="../images/logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="logo hopital">
            Hopital
        </a>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                Fiche du patient
            </li>
        </ul>
    </nav>
    <div class="container d-flex flex-column h-100">
        <div class="mx-auto my-5 px-5 py-3 border">
        <?php
        if(isset($_GET['insertion'])) {
            echo "<div class='alert alert-success' role='alert'>Document bien inséré.</div>";
        }

        // Recherche d'un patient à partir de son code
        function recherche_patient($bdd, $id) {
            $id = $bdd->quote($id);
            $requete = "SELECT patients.code, nom, prenom, date_naissance,
            num_sec_soc, date_prem_entree, sexe, code_pays, code_motifs,
            motifs.libelle AS 'LibelleDuMotif', pays.libelle AS 'LibelleDuPays',
            sexe.libelle AS 'LibelleDuSexe'
            FROM patients
            INNER JOIN pays ON (patients.code_pays = pays.code)
            INNER JOIN motifs ON (patients.code_motifs = motifs.code)
            INNER JOIN sexe ON (patients.sexe = sexe.code)
            WHERE patients.code = $id;";
            try {
                $resultats = $bdd->query($requete);
            } catch (PDOException $e) {
                exit("Erreur lors de l'exécution de la requête : " . $e->getMessage());
            }
            return $resultats;
        }

        // Recherche d'un document à partir de son id
        function recherche_ressources($bdd, $id) {
            $id = $bdd->quote($id);
            $requete = "SELECT id, reference_document.nom, code_patients
            FROM reference_document
            INNER JOIN patients ON (patients.code = reference_document.code_patients)
            WHERE patients.code = $id;";
            try {
            $resultats = $bdd->query($requete);
            } catch (PDOException $e) {
            exit("Erreur lors de l'exécution de la requête : " . $e->getMessage());
            }
            return $resultats;
        }

        // Affichage du détail de la fiche du patient
        function affiche_details_patient($patient) {
            $date_naissance = formateDate($patient['date_naissance']);
            $date_prem_entree = formateDate($patient['date_prem_entree']);

            // Genre du patient pour information
            if ($patient['sexe'] == 'M') {
                $genre = "Mr";
            } else {
                $genre = "Mme";
            }

            $nom = strtoupper(htmlspecialchars($patient['nom'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING));
            $prenom = htmlspecialchars($patient['prenom'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;

            // Titre de la fiche
            echo "<h1>$genre $nom $prenom</h1>\n";

            echo "<ul class=\"list-group\">\n";
            // Code du patient
            echo "<li class=\"list-group-item\"><strong>Code patient : </strong>"
            . $patient['code']."</li>";
            
            // Nom du patient
            echo "<li class=\"list-group-item\"><strong>Nom : </strong>"
            . $nom . "</li>\n";

            // Prénom du patient
            echo "<li class=\"list-group-item\"><strong>Prénom : </strong>"
            . $prenom . "</li>\n";

            // Date de naissance du patient
            echo "<li class=\"list-group-item\"><strong>Date de naissance : </strong>"
            . htmlspecialchars($date_naissance,HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING) . "</li>\n";

            // Pays de naissance
            echo "<li class=\"list-group-item\"><strong>Pays de naissance : </strong>"
            . htmlspecialchars($patient['LibelleDuPays'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING) . "</li>\n";

            // Genre
            echo "<li class=\"list-group-item\"><strong>Genre : </strong>"
            . htmlspecialchars($patient['LibelleDuSexe'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING). "</li>\n";

            // Motif d'admission
            echo "<li class=\"list-group-item\"><strong>Motif d'admission : </strong>"
            . htmlspecialchars($patient['LibelleDuPays'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING). "</li>";

            // Date de première admission
            echo "<li class=\"list-group-item\"><strong>Date de première admission : </strong>"
            . htmlspecialchars($date_prem_entree,HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING) . "</li>\n";

            // Posséssion d'un numéro de sécurité sociale ou non.
            if ($patient['num_sec_soc']) {
            $num_sec_soc = $patient['num_sec_soc'];
            } else {
            $num_sec_soc = 'Aucun';
            }

            // Numéro de sécurité sociale.
            echo "<li class=\"list-group-item\"><strong>Numéro de sécurité sociale : </strong>"
            . htmlspecialchars($num_sec_soc,HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING) . "</li>\n";
            echo "</ul>\n";
        }

        //
        function affiche_document($documents): void {
            echo "<h3 class='my-3'>Options pour document :</h3>\n";
            echo "<p class='my-3'><a href='document_patient.php?code=".$_GET['code']."'>Ajouter un nouveau document.</a></p>";

            if ($documents && $documents->rowCount() > 0) {
                echo '<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Document</th>
                        <th scope="col">Consulter</th>
                        <th scope="col">Télécharger</th>
                        <th scope="col">Envoyer par mail</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($documents as $document) {
                    $nom_doc = htmlspecialchars($document['nom'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);
                    echo '<tr>
                        <td>'.$nom_doc.'</td>
                        <td style="text-align: center"><a href="../ressources/'.$nom_doc.'" target="_blank"><i class="far fa-eye" style="color: black"></i></a></td>
                        <td style="text-align: center"><a class="my-auto" href="../ressources/'.$nom_doc.'" download><i class="far fa-save" style="color: black"></i></a></td>
                        <td style="text-align: center"><a href="mailto:example@example.com?subject=Envoi de document du patient '.$_SESSION['nom'].' '.$_SESSION['prenom'].'&body= Lien du document : C:/wamp64/www/Hopital/ressources/'.$nom_doc.'"><i class="far fa-envelope" style="color: black"></i></a></td>
                    </tr>';
                }  
                echo "</tbody>
                </table>";
            } else {
                echo "<p>Aucun document sur le patient.</p>\n";
            }
        }

        if (!empty($_GET['code'])) {
            // Lecture des informations sur le patient souhaité
            $bdd = PDO_connecte_MySQL();
            $patient = recherche_patient($bdd, $_GET['code']);
            $ressources = recherche_ressources($bdd, $_GET['code']);
            unset($bdd);
            
            // Affichage des détails
            if ($patient && $patient->rowCount() > 0) {
              affiche_details_patient($patient->fetch(PDO::FETCH_ASSOC));
              unset($patient);
            } else {
              echo "<p>Aucun patient ne correspond.</p>\n";
            }
        
            // Si document présent
            affiche_document($ressources);
        } else {
            echo "<p>Erreur : la page a été appelée sans l'identifiant du patient à afficher.</p>\n";
        }
        
        // Renvoie vers le formulaire de recherche
        echo "<p><a href=\"recherche_patient.php\">Retour</a></p>\n";

        session_destroy();
        ?>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/dcd6ace8e4.js" crossorigin="anonymous"></script>
</body>
</html>