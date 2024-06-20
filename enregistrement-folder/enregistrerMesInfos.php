<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

// Récupérer les données du formulaire
$adresse = $_POST["adresse"];
$numero = $_POST["numero"];
$email = $_POST["email"];
$pseudo = $_SESSION['pseudo'];

// Ouvrir le fichier CSV en lecture et en écriture
$file = fopen('../csv-folder/salarie.csv', 'r');
$tempFile = fopen('../csv-folder/temp_personnes.csv', 'w'); // fichier temporaire pour écrire les modifications

if ($file && $tempFile) {
    while (($ligne = fgetcsv($file, 0, ';')) !== false) {
        if (isset($ligne[7]) && $ligne[7] == $pseudo) {
            // Mettre à jour les informations de l'utilisateur actuel
            $ligne[4] = $adresse;
            $ligne[5] = $numero;
            $ligne[6] = $email;
        }
        fputcsv($tempFile, $ligne, ';'); // Écrire la ligne dans le fichier temporaire
    }

    fclose($file);
    fclose($tempFile);

    // Renommer le fichier temporaire pour remplacer l'original
    rename('../csv-folder/temp_personnes.csv', '../csv-folder/salarie.csv');
} else {
    echo "Erreur lors de l'ouverture des fichiers CSV.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css-folder/enregistrement.css">
    <title>Enregistement des modifications</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = '../Salariés/Infopage.php';">Accueil</button>
    </div>
    <h3>Vos modifications ont bien été enregistrées</h3>
</body>
</html>
