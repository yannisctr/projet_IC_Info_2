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
    <link rel="stylesheet" href="../css-folder/enregistrement.css">
    <title>Enregistrer une absence</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = 'accueil-section.php';">Accueil</button>
        <button class="b1" type="button" onclick="location.href = '../deconnexion.php';">Déconnexion</button>
    </div>
    <?php
    $jours = $_POST["jour"];
    $mois = $_POST["mois"];
    $userId = $_POST['userId'];

    $date = $mois."-".$jours;
    $status = 0;

    $infos = array(
        array($date, $status));


    function ecrire($infos,$userId) {
        $filePath = "../Salariés/".$userId."/Absences.csv";
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
    function modifyCSV($filePath, $lineNumber) {
        // Lire le fichier CSV dans un tableau
        $file = fopen($filePath, 'r');
        $rows = [];
        
        while (($line = fgetcsv($file)) !== false) {
            $rows[] = $line;
        }
        fclose($file);
        
        // Vérifier si la ligne demandée existe
        if (isset($rows[$lineNumber - 1])) {
            // Modifier la valeur de la colonne 4 (index 3 car les index commencent à 0)
            $rows[$lineNumber - 1][8] += 1;
        } else {
            echo "La ligne $lineNumber n'existe pas dans le fichier CSV.\n";
            return;
        }

        // Ouvrir le fichier CSV en écriture
        $file = fopen($filePath, 'w');
        
        // Écrire chaque ligne modifiée dans le fichier CSV
        foreach ($rows as $row) {
            fputcsv($file, $row);
        }
        
        // Fermer le fichier
        fclose($file);
        
        echo "La valeur de la colonne 4 de la ligne $lineNumber a été incrémentée de 1.\n";
    }



    function afficherTableau2D($userId) {
        $filePath = "../Salariés/".$userId."/Absences.csv";
        $row = 0;
        $tampon =0;
        if (($handle = fopen($filePath, "r"))) {
            echo "<table border='1'>";
            while (($data = fgetcsv($handle, 1000, ";"))) {
              if ($tampon == 0) {
                $tampon += 1;
              }
              else 
              {
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
                
            }
            echo "</table>";
            fclose($handle);
        } else {
            die("Erreur: Impossible d'ouvrir le fichier $filePath");
        }
    }

    $chemin = "../Salariés/".$userId."/RecapMensuel.csv";
    ecrire($infos,$userId);
    modifyCSV($chemin,$mois+1);
    afficherTableau2D($userId);

    ?>

    <button><a href="accueil-section.php">Retour</a></button>
</body>
</html>
