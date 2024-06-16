<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Lina">
    <link rel="stylesheet" type="text/css" href="styleTraitementConges.css">
    <link rel="shortcut icon" href="images/logo.png">
    <title>Validation congés</title>
</head>
<body>
    <img class="logo" src="logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="accueil.html" class="link">Accueil</a>
        <a href="deconnexion.html" class="link">Déconnexion</a>
    </div>

    <h1>Validation congés</h1>

    <?php
    $mois= [
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Partie pour afficher le haut du tableau
        echo "<table border='1'>";
        // Écriture des en-têtes dans le fichier CSV
        echo "<tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
                <th>Validation</th>
              </tr>";

        // Ouverture du fichier CSV en mode lecture
        $file = fopen('demandeconges.csv', 'r');
        $cpt = 0; // Pour compter le nb de lignes
        $time = 0; 

        // Boucle tant que le fichier n'a pas été entièrement parcouru
        while (($ligne = fgetcsv($file)) !== false) {
            if ($time == 0) {
                $time += 1;
            }
            else 
            {
                $tampon = explode('-',$ligne[2]);
                $tampon[0] += -1; 
                $mois_du_conge = $mois[$tampon[0]]; 
                if (count($ligne) >= 4) {
                    // Récupération de l'info pour la ligne
                    $rep = isset($_POST['validation'][$cpt]) ? $_POST['validation'][$cpt] : "non spécifié";
                    
                    $cpt++;
               
                    // Partie affichage
                    echo "<tr>
                            <td>{$ligne[0]}</td>
                            <td>{$ligne[1]}</td>
                           <td>{$tampon[1]} $mois_du_conge </td>
                            <td>{$rep}</td>
                          </tr>";
    
                    // Écriture dans le CSV que si la réponse est "oui"
                    /*if ($rep == "oui") {
                        $fileRep = fopen('congesvalid.csv', 'a+');
                        $infos = array($ligne[0], $ligne[1], $ligne[2], $ligne[3]);
                        fputcsv($fileRep, $infos);
                        fclose($fileRep);
                    }
*/
                    if ($rep == "oui") {
                        $fileconge = fopen('../Salariés/'.$ligne[3].'/congés.csv', 'r');
                        $newDate = $ligne[2]; 
                        $content = [];
                        
                        // Read the existing content
                        while (($line = fgetcsv($fileconge)) !== false) {
                            $content[] = $line;
                        }
                        fclose($fileconge);
                        
                        // Check if the second line exists
                        if (isset($content[1])) {
                            // Append the new date to the second line
                            $content[1][] = $newDate;
                        } else {
                            // Create the second line if it doesn't exist and add the new date
                            // Ensure the first line is not empty before creating the second line
                            if (isset($content[0])) {
                                $content[1] = [$newDate];
                            } else {
                                // If the file is empty, create the first line and then the second line
                                $content[0] = [];
                                $content[1] = [$newDate];
                            }
                        }
                        
                        // Open the file for writing
                        $fileconge = fopen('../Salariés/'.$ligne[3].'/congés.csv', 'w');
                        
                        // Write the updated content back to the file
                        foreach ($content as $line) {
                            fputcsv($fileconge, $line);
                        }
                        fclose($fileconge);

                        $fileconge = fopen('../Salariés/'.$ligne[3].'/RecapMensuel.csv', 'w');
                    }

                }

            }
        
        }

        // Fermeture du fichier
        fclose($file);

        echo "</table>";
    } else {
        echo "<p>Aucune donnée soumise.</p>";
    }
    ?>
</body>
</html>
