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
    <title>Enregistement de la suppression</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
    </div>
    <?php

    $salarie = $_POST["salarie"];

    function verifDoublons($salarie) {
        $temp = fopen('csv-folder/temp.csv', 'w');
        if (($handle = fopen("csv-folder/salarie.csv", "a+"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                if ($data[7] == $salarie) {
                    echo "<p>le salarié a bien été supprimé !</p><br>";
                    continue;
                } else {
                    fputcsv($temp, $data, ';');
                }
            }
            fclose($handle);
            fclose($temp);
            rename('csv-folder/temp.csv', 'csv-folder/salarie.csv');
        }
    }

    verifDoublons($salarie);
    
    ?>

    <button><a href="accueil-salarie.php">retour</a></button>
</body>
</html>