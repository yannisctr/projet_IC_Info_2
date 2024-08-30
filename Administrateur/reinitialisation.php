<?php
session_start();

// Vérifier si le nom du salarié est bien passé en POST
if (!isset($_POST['nomSalarie']) || empty($_POST['nomSalarie'])) {
    die("Erreur : Nom du salarié non spécifié.");
}

// Sécuriser le nom du salarié pour éviter les injections de chemin
$nomSalarie = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['nomSalarie']);

// Définir le répertoire de base
$baseDir = '../Salariés/' . $nomSalarie . '/';

// Liste des fichiers à réinitialiser
$fichiers = ['congés.csv', 'horaires.csv', 'Absences.csv', 'RecapMensuel.csv'];

foreach ($fichiers as $fichier) {
    $filename = $baseDir . $fichier;
    
    // Vérifier si le fichier existe
    if (!file_exists($filename)) {
        echo "Le fichier $fichier n'existe pas.<br>";
        continue;
    }
    
    // Lire le contenu du fichier
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Vérifier s'il y a au moins une ligne dans le fichier
    if (count($lines) == 0) {
        echo "Le fichier $fichier est vide.<br>";
        continue;
    }
    
    // Vérifier s'il n'y a que la première ligne (en-tête)
    if (count($lines) == 1) {
        echo "Le fichier $fichier ne contient que la première ligne, aucune modification n'a été effectuée.<br>";
        continue;
    }
    
    // Garder seulement la première ligne
    $content = $lines[0] . PHP_EOL;
    
    // Écrire le contenu mis à jour dans le fichier
    if (file_put_contents($filename, $content) !== false) {
        echo "Le fichier $fichier a été réinitialisé.<br>";
    } else {
        echo "Erreur lors de la réinitialisation du fichier $fichier.<br>";
    }
}

echo "Opération terminée.";
?>
