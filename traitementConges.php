<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Lina">
    <link rel="stylesheet" type="text/css" href="css-folder/styleTraitementConges.css">
    <link rel="shortcut icon" href="css-folder/images/logo.png">
    <title>Validation congés</title>
</head>
<body>
    <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="../accueil.php" class="link">Accueil</a>
        <a href="../deconnexion.php" class="link">Déconnexion</a>
    </div>

    <h1>Validation congés</h1>

    <?php
    $mois = [
        "Janvier", 
        "Fevrier", 
        "Mars",
        "Avril",
        "Mai", 
        "Juin", 
        "Juillet",
        "Aout", 
        "Septembre", 
        "Octobre", 
        "Novembre", 
        "Decembre"
    ];

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
            $rows[$lineNumber - 1][3] += 1;
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<table border='1'>";
        echo "<tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
                <th>Validation</th>
              </tr>";

        $file = fopen('csv-folder/demandeconges.csv', 'r');
        $cpt = 0;
        $time = 0;

        while (($ligne = fgetcsv($file)) !== false) {
            if ($time == 0) {
                $time += 1;
            } else {
                $tampon = explode('-', $ligne[2]);
                $tampon[0] += -1; 
                $mois_du_conge = $mois[$tampon[0]];

                if (count($ligne) >= 4) {
                    $rep = isset($_POST['validation'][$cpt]) ? $_POST['validation'][$cpt] : "non spécifié";
                    $cpt++;

                    echo "<tr>
                            <td>{$ligne[0]}</td>
                            <td>{$ligne[1]}</td>
                            <td>{$tampon[1]} $mois_du_conge</td>
                            <td>{$rep}</td>
                          </tr>";

                    if ($rep == "oui") {
                        $filecongePath = 'Salariés/'.$ligne[3].'/congés.csv';
                        $fileconge = fopen($filecongePath, 'r');
                        $newDate = $ligne[2]; 
                        $content = [];

                        while (($line = fgetcsv($fileconge)) !== false) {
                            $content[] = $line;
                        }
                        fclose($fileconge);

                        if (isset($content[1])) {
                            $content[1][] = $newDate;
                        } else {
                            if (isset($content[0])) {
                                $content[1] = [$newDate];
                            } else {
                                $content[0] = [];
                                $content[1] = [$newDate];
                            }
                        }

                        $fileconge = fopen($filecongePath, 'w');

                        foreach ($content as $line) {
                            fputcsv($fileconge, $line);
                        }
                        fclose($fileconge);

                        $fileRecapPath = 'Salariés/'.$ligne[3].'/RecapMensuel.csv';
                        $month = explode('-', $newDate);
                        $lineNumber = $month[0] +1;

                        modifyCSV($fileRecapPath, $lineNumber);
                    }
                }
            }
        }

        fclose($file);
        echo "</table>";
    } else {
        echo "<p>Aucune donnée soumise.</p>";
    }
    ?>
</body>
</html>
