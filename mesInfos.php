<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css-folder/mesInfos.css">
    <title>Mes Informations</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
        <div class="header-buttons">
            <button class="b1" type="button" onclick="location.href = 'Salariés/Infopage.php';">Accueil</button>
            <button class="b1" type="button" onclick="location.href = 'deconnexion.php';">Déconnexion</button>
        </div>
    </div>

    <h1>Mes infos</h1>
    <p>Si certaines informations vous concernant ne sont plus à jour, merci de les modifier <a href="modifMesInfos.php" class="link">ici</a></p>

    <?php
    // Ouverture du fichier avec les infos de tout le monde
    $file = fopen('csv-folder/salarie.csv', 'r');

    // Récupération du pseudo de l'utilisateur connecté
    $pseudo = $_SESSION['pseudo'];

    // Parcours du fichier CSV pour trouver les infos de l'utilisateur
    while (($ligne = fgetcsv($file, 0, ';')) !== false) {
        if (isset($ligne[7]) && $ligne[7] == $pseudo) {
            echo "
            <div class='mesInfos'>
                <p><strong>Prénom :</strong> $ligne[1]</p>
                <p><strong>Nom :</strong> $ligne[0]</p>
                <p><strong>Contrat :</strong> $ligne[2]</p>
                <p><strong>Sport :</strong> $ligne[3]</p>
                <p><strong>Adresse :</strong> $ligne[4]</p>
                <p><strong>Tel :</strong> $ligne[5]</p>
                <p><strong>Mail :</strong> $ligne[6]</p>
                <p><strong>Identifiant :</strong> $ligne[7]</p>
            </div>
            ";
            break;
        }
    }

    fclose($file); // Fermeture du fichier
    ?>
</body>
</html>
