<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css-folder/modifInfo.css">
    <title>Modifier les coordonnées</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
        <div class="header-buttons">
            <button class="b1" type="button" onclick="location.href = 'Salariés/Infopage.php';">Accueil</button>
            <button class="b1" type="button" onclick="location.href = 'mesInfos.php';">Mes infos</button>
            <button class="b1" type="button" onclick="location.href = 'deconnexion.php';">Déconnexion</button>
        </div>
    </div>

    <div class="centeredcase">
        <h1>Modifier les coordonnées</h1>
        <form action="enregistrement-folder/enregistrerMesInfos.php" method="POST">
            <div class="form-group">
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" placeholder="Adresse" required>
            </div>
            <div class="form-group">
                <label for="numero">Numéro :</label>
                <input type="text" id="numero" name="numero" placeholder="Numéro" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" placeholder="Mail" required>
            </div>
            <input type="submit" value="Enregistrer">
        </form>
    </div>
</body>
</html>
