<?php
session_start();

// Vérifiez que le champ 'nouv_section' est bien présent dans le formulaire POST
if (isset($_POST['nouv_section'])) {
    $section = $_POST['nouv_section'];

    // Ouvrir le fichier en mode ajout
    $file = fopen("csv-folder/Liste_sections.csv", "a+");
    if ($file === false) {
        die("Erreur: Impossible d'ouvrir le fichier Liste_sections.csv");
    }

    // Ajouter la section en tant que nouvelle ligne CSV
    fputcsv($file, [$section]);

    // Fermer le fichier après l'écriture
    fclose($file);

    // Rediriger vers la page 'ajouter-salarie.php'
    header('Location: ajouter-salarie.php');
    exit();
} else {
    // Gérer le cas où 'nouv_section' n'est pas défini dans POST
    die("Erreur: La section n'a pas été spécifiée.");
}
?>
