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
    <div class="mesInfos">
        <h1>Modifier les coordonnées</h1><br>
        <form action="enregistrerMesInfos.php" method="POST">
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