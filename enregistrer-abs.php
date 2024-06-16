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
    <link rel="stylesheet" href="css-folder/enregistrement.css">
    <title>Enregistrer une absence</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
    </div>
    <?php
    $jours = $_POST["jour"];
    $mois = $_POST["mois"];

    $date = $jours."-".$mois;
    $status = 0;

    $infos = array(
        array($date, $status));


    function ecrire($infos) {
        $filePath = "absences.csv";
        $file = fopen($filePath, "a+");
        if ($file === false) {
            die("Erreur: Impossible d'ouvrir le fichier $filePath");
        }
        foreach ($infos as $ligne) {
            if (fputcsv($file, $ligne, ";") === false) {
                fclose($file);
                die("Erreur: Impossible d'écrire dans le fichier $filePath");
            }
        }
        fclose($file);
    }

    function afficherTableau2D() {
        $filePath = "absences.csv";
        $row = 0;
        if (($handle = fopen($filePath, "r"))) {
            echo "<table border='1'>";
            while (($data = fgetcsv($handle, 1000, ";"))) {
                echo "<tr>";
                if ($row == 0) {
                    echo "<td>Date</td>";
                    echo "<td>Status</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>$data[0]</td>";
                    if ($data[1]==0){
                        echo "<td>injustifiée</td>";
                    }if($data[1]==1){
                        echo "<td>justifiée</td>";
                    }
                    
                    echo "</tr>";
                    $row += 1;
                } else {
                    echo "<td>$data[0]</td>";
                    if ($data[1]==0){
                        echo "<td>injustifiée</td>";
                    }if($data[1]==1){
                        echo "<td>justifiée</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
            fclose($handle);
        } else {
            die("Erreur: Impossible d'ouvrir le fichier $filePath");
        }
    }


    ecrire($infos);
    afficherTableau2D();
    ?>

    <button><a href="accueil-admin.php">Retour</a></button>
</body>
</html>
