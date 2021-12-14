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
    <meta name="description" content="Document d'un patient dans un hopital">

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
                Ajout de documentation d'un patient
            </li>
        </ul>
    </nav>
    <div class="container d-flex flex-column h-100 mt-5">
        <div class="m-auto my-5 px-5 py-3 border">
            <h1>Nouveau document du patient</h1>

            <p class="mb-3">Taille maximum du fichier : <strong>10Mo</strong>. Fichiers autorisés : <strong>txt, pdf, jpg, jpeg, png</strong></p>

            <form action="document_patient.php?code=<?php echo $_GET['code'] ?>" method="POST" enctype="multipart/form-data">
                <legend>Ajouter un fichier pour le patient n°<?php echo $_GET['code'] ?></legend>

                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" name="myInput" id="myInput" aria-describedby="myInput">
                    <label class="custom-file-label" for="myInput">Sélectionner un fichier</label>
                </div>

                <input class="btn btn-primary mb-3" type="submit" value="Enregistrer">
            </form>

            <?php
            if(isset($_FILES['myInput'])) {
                $file = $_FILES['myInput'];

                // Propriétés du fichier
                $file_name = $file['name'];
                $file_tmp = $file['tmp_name'];
                $file_size = $file['size'];
                $file_error = $file['error'];

                // Séparation nom et extension
                $file_ext = explode('.', $file_name);
                // Extension du fichier
                $file_ext = strtolower(end($file_ext));
                // Extensions autorisés
                $allowed = array('txt','pdf','jpg','jpeg','png', 'TXT', 'PDF', 'JPG', 'JPEG', 'PNG');

                if(in_array($file_ext, $allowed) ) {
                    if ($file_error === 0) {
                        if ($file_size <= 10485760) {
                            if (check_same_name_file($file_name)) {
                                $file_destination = "../ressources/" . $file_name;
                                if(move_uploaded_file($file_tmp, $file_destination) && save_file($file_name)) {
                                    header('Location:fiche_patient.php?code='.$_GET['code'].'&insertion=true');
                                } else {
                                    echo "<p class='erreur'>Echec insertion du fichier.</p>";
                                }
                            } else {
                                echo "<p class='erreur'>Un fichier du même nom est déjà existant.</p>";
                            }
                        } else {
                            echo "<p class='erreur'>Le fichier est trop lourd.</p>";
                        }
                    } else {
                        echo "<p class='erreur'>Erreur lors de l'insertion.</p>";
                    }
                } else {
                    echo "<p class='erreur'>Fichier comportant une extension non autorisé.</p>";
                }
            }

            // Vérifie si 2 fichiers ont le même nom
            function check_same_name_file($file_name): bool {
                $bdd = PDO_connecte_MySQL();
                $requete = "SELECT nom FROM reference_document;";
                try {
                  $resultats = $bdd->query($requete);
                } catch (PDOException $e) {
                  exit("Erreur lors de l'exécution de la requête : " . $e->getMessage());
                }
            
                foreach ($resultats as $resultat) {
                  $nom = htmlspecialchars($resultat['nom'],HTMLSPECIALCHARS_FLAGS,HTMLSPECIALCHARS_ENCODING);
                  if ($nom == $file_name) {
                    return false;
                  }
                }

                unset($resultats);
                unset($bdd);
                return true;
            }

            // Sauvegarde le fichier de l'utilisateur
            function save_file($file_name): bool {
                $code = intval($_GET['code']);
            
                $bdd = PDO_connecte_MySQL();
                $requete = "INSERT INTO reference_document (nom, code_patients) 
                    VALUES (\"".$file_name."\", $code);";
                try {
                    $lignes_insert = $bdd->exec($requete);
                } catch (PDOException $e) {
                    exit("Erreur lors de l'exécution de la requête : " . $e->getMessage());
                }
        
                if ($lignes_insert == 1) {
                    return true;
                }
                return false;
            }
            ?>
        </div>
    </div>

    <!-- JS -->
    <script src="../js/main.js"></script>
</body>
</html>