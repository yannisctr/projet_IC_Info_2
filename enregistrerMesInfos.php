<?php

// ouverture du fichier avec les infos de tout le monde
$file = fopen('personnes.csv', 'r');
$tempFile = fopen('temp_personnes.csv', 'w'); // fichier temporaire pour écrire les modifications

$pseudo = 'mmartin'; // à modifier : avec la session et tout, on aura déjà le pseudo de la personne

while (($ligne = fgetcsv($file, 0, ';')) !== false) {
    if (isset($ligne[7]) && $ligne[7] == $pseudo) {
        // mise à jour des infos
        $ligne[4] = $_POST["adresse"];
        $ligne[5] = $_POST["numero"];
        $ligne[6] = $_POST["email"];
        
        echo "
        <div class='mesInfos'>
        <p>Prénom : $ligne[1] </p><br>
        <p>Nom : $ligne[0] </p><br>
        <p>Contrat : $ligne[2] </p><br>
        <p>Sport : $ligne[3] </p><br>
        <p>Adresse : $ligne[4] </p><br>
        <p>Tel : $ligne[5] </p><br>
        <p>Mail : $ligne[6] </p><br>
        <p>Identifiant : $ligne[7] </p><br>
        </div>
        ";
    }
    fputcsv($tempFile, $ligne, ';'); // écriture des lignes, y compris les modifications, dans le fichier temporaire
}

fclose($file);
fclose($tempFile);

// remplacement du fichier original par le fichier temporaire
rename('temp_personnes.csv', 'personnes.csv');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les coordonnées</title>
</head>
<body>
    <img class="logo" src="logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="accueilVide.html" class="link">Accueil</a>
        <a href="mesInfos.php" class="link">Mes infos</a>
        <a href="deconnexion.html" class="link">Déconnexion</a>
        
    </div>
    <div>
    <h1>Mes nouvelles infos</h1><br>
    </div>
    <div class="mesInfos">
        

    </div>
</body>
</html>
