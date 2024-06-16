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
    $chemin1 = "salariés/".$_SESSION["pseudo"]."/Absences.csv";
    $chemin2 = "salariés/".$_SESSION["pseudo"]."/RecapMensuel.csv";

    $date = $jours."-".$mois;
    $status = 0;

    $infos = array(
        array($date, $status));


    function ecrire($infos, $chemin) {
        $filePath = $chemin;
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

    function verifDoublons($chemin){
        $temp = fopen('temp.csv', 'w');
        if (($handle = fopen($chemin, "a+"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                if ($data[2] == 0) {
                    $data[8] = 1;
                    $data[5] = "toto";
                    $data[6] = "toto";
                }
                fputcsv($temp, $data, ';');
            }
            fclose($handle);
            fclose($temp);
            rename('temp.csv', $chemin);
        }
    }

    function afficherTableau2D($chemin) {
        $filePath = $chemin;
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


    ecrire($infos, $chemin1);
    afficherTableau2D($chemin1);
    verifDoublons($chemin2);
    ?>

    <button><a href="Administrateur/accueil-admin.php">Retour</a></button>
</body>
</html>
