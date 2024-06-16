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
    <title>Enregistement des modifications</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
    </div>
    <?php
    $adresse = $_POST["adresse"];
    $numero = $_POST["numero"];
    $email = $_POST["email"];

    function verifDoublons($adresse, $numero, $email){
        $temp = fopen('csv-folder/temp.csv', 'w');
        if (($handle = fopen("csv-folder/salarie.csv", "a+"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                if ($data[7] == $_SESSION["pseudo"]) {
                    $data[4] = $adresse;
                    $data[5] = $numero;
                    $data[6] = $email;
                }
                fputcsv($temp, $data, ';');
            }
            fclose($handle);
            fclose($temp);
            rename('csv-folder/temp.csv', 'csv-folder/salarie.csv');
        }
    }

    function afficherTableau2D(){
        $row = 0;
        if (($handle = fopen("csv-folder/salarie.csv", "r"))) {
            echo "<table border='1'>";
            while (($data = fgetcsv($handle, 1000, ";"))) {
                echo "<tr>";
                if ($row == 0) {
                    echo "<td>Adresse</td>";
                    echo "<td>Numéro de téléphone</td>";
                    echo "<td>email</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>$data[4]</td>";
                    echo "<td>$data[5]</td>";
                    echo "<td>$data[6]</td>";
                    echo "</tr>";
                    $row += 1;
                } else {    
                    echo "<td>$data[4]</td>";
                    echo "<td>$data[5]</td>";
                    echo "<td>$data[6]</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            fclose($handle);
        }    
    }

    verifDoublons($adresse, $numero, $email);

    afficherTableau2D();
    
    ?>

    <button><a href="accueil-folder/accueil-salarie.php">retour</a></button>

</body>
</html>