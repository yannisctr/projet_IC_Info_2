<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement de la suppression</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
    </div>
    <?php

    function supprimerSalarie($salarie_id) {
        // Chemin vers le dossier du salarié
        $cheminDossier = "../Salariés/" . $salarie_id;

        // Vérifier si le dossier du salarié existe
        if (is_dir($cheminDossier)) {
            // Supprimer le dossier spécifique du salarié
            deleteDir($cheminDossier);
        }

        // Supprimer l'entrée correspondante dans le fichier CSV
        $temp = fopen('../csv-folder/temp.csv', 'w');
        if (($handle = fopen("../csv-folder/salarie.csv", "a+"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                if ($data[7] == $salarie_id) {
                    echo "<p>Le salarié $salarie_id a bien été supprimé !</p><br>";
                    continue;
                } else {
                    fputcsv($temp, $data, ';');
                }
            }
            fclose($handle);
            fclose($temp);
            rename('../csv-folder/temp.csv', '../csv-folder/salarie.csv');
        }
    }

    // Fonction récursive pour supprimer un dossier et son contenu
    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            return;
        }

        // Ouvrir le dossier
        $dir = opendir($dirPath);

        // Parcourir tous les éléments du dossier
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $filePath = $dirPath . '/' . $file;

                // Vérifier si l'élément est un dossier
                if (is_dir($filePath)) {
                    // Appeler récursivement deleteDir pour supprimer le sous-dossier
                    deleteDir($filePath);
                } else {
                    // Supprimer le fichier
                    unlink($filePath);
                }
            }
        }

        // Fermer le dossier
        closedir($dir);

        // Supprimer le dossier spécifique maintenant qu'il est vide
        rmdir($dirPath);
    }

    // Vérifier si l'ID du salarié à supprimer est présent dans l'URL
    if (isset($_GET['id'])) {
        $salarie_id = $_GET['id'];

        // Afficher un formulaire de confirmation
        echo "<form method='post'>";
        echo "<p>Confirmez-vous la suppression du salarié avec l'ID : $salarie_id ?</p>";
        echo "<input type='hidden' name='salarie_id' value='$salarie_id'>";
        echo "<input type='submit' name='confirmer' value='Confirmer'>";
        echo "</form>";

        // Traitement après la soumission du formulaire de confirmation
        if (isset($_POST['confirmer'])) {
            $salarie_id = $_POST['salarie_id'];
            supprimerSalarie($salarie_id);
        }
    } else {
        echo "ID du salarié non spécifié.";
    }

    ?>

    <button><a href="accueil-admin.php">Retour</a></button>
</body>
</html>
