<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

/**$demandes = array();
if (($handle = fopen("csv-folder/demandes_secretaire.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $demandes[] = $data;
    }
    fclose($handle);
}*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css-folder/accueil-admin-style.css">
    <title>Accueil</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = '../deconnexion.php';">Déconnexion</button>
    </div>
    <div>
        <h3>Bonjour Secretaire</h3>
        <h3>Que souhaitez-vous faire :</h3>
    </div>
    <div class="buttons-container">
        <button class="b2"><a href="../ajouter-salarie.php"><img src="../img-package/user-2.png" alt="Ajouter un salarié"><span>Ajouter un salarié</span></a></button>
        <button class="b2"><a href="rechercherSalarie.php"><img src="../img-package/user-13.png" alt="Voir les informations des salariés"><span>Voir les informations des salariés</span></a></button>
        <button class="b2"><a href="../validerCongés.php"><img src="../img-package/user-14.png" alt="Voir les congés"><span>Voir les demandes de congés</span></a></button>
        <button class="b2"><a href="../gerer-abs.php"><img src="../img-package/user-15.png" alt="Gérer les absences"><span>Gérer les absences</span></a></button>
    </div>

    
    
</body>
</html>
