<?php
session_start();
function searchByName($filename, $searchName) {
    // ouverture du fichier en lecture
    if (($handle = fopen($filename, "r")) !== FALSE) {
        // Parcourt chaque ligne du fichier
        $taille = strlen($searchName);


        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            // Supposons que le nom se trouve dans la première colonne (index 0)
            if (strcasecmp(substr($data[0],0,$taille), $searchName) == 0 || strcasecmp(substr($data[1],0,$taille), $searchName) == 0 ) {
                // Affiche la ligne complète si le nom correspond
                echo "" . $data[0] . ", " . $data[1] . "\n";
                $employee_id = $data[7]; // récupère le pseudo du salarié dans la 7e colonne du csv
                //renvoie id du salarié à la page du salarié
                echo '<a href="Infopage.php?id=' . urlencode($employee_id) . '" class="button">voir la page du salarié</a>';
                echo "<br>";
            }
        }
        // Ferme le fichier
        fclose($handle);
    } else {
        echo "Impossible d'ouvrir le fichier.";
    }
}

// Nom du fichier CSV
$filename = "../csv-folder/salarie.csv";
// Nom à rechercher A RAJOUTER
$searchName = $_POST['search'];

// Appelle la fonction de recherche
searchByName($filename, $searchName);
?>
