<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un salarié</title>
</head>
<body>
    <div>
        <h1>Supprimer un salarié</h1><br>
        <form action="enregistrer-suppression.php" method="post">
            <input type="text" id="salarie" name="salarie" placeholder="identifiant du salarié" required><br><br>
            <input type="submit" value="Supprimer le salarié">
        </form>
    </div>
</body>
</html>