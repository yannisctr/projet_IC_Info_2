<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="traitementconge.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="../img-package/logo_alb.png">
        <title>Gestion Conge</title>
    
    </head>
    <body>
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">

        <nav>
            <a href="Infopage.php" class="link">Accueil</a>
            <a href="deconnexion.html" class="link">Déconnexion</a>  
        </nav>
    
        <?php

// Fonction pour ajouter une date de congé dans le fichier CSV
function ajouterCongeCSV($date_conge) {
    $mois_noms =[
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];
    
    $timestamp = strtotime($date_conge);
    $mois = date('n', $timestamp); // Permet d'enlever les zero initiaux
    $jour = date('j', $timestamp); 

    // Format "mois-jour"
    $date_formattee =array($_SESSION['nom'],$_SESSION['prenom'],"$mois-$jour",$_SESSION['pseudo'] ) ;

   
    $csvFile = '../csv-folder/demandeconges.csv';
    if (($handle = fopen($csvFile, 'a+')) !== FALSE) {
        fputcsv($handle, [$date_formattee]);
        fclose($handle);

        echo " <p> Votre demande pour le $jour ".$mois_noms[$mois]." a été pris en compte. </p>";
    } else {
        echo "Erreur lors de l'ouverture du fichier CSV.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date']) && !empty($_POST['date'])) {
        // Appeler la fonction pour ajouter la date de congé dans le fichier CSV
        ajouterCongeCSV($_POST['date']);
    } else {
        echo "<p> Veuillez fournir une date de congé. </p>";
    }
} else {
    echo "Aucune donnée reçue.";
}

?>




</body>
</html>


