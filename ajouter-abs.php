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
    <link rel="stylesheet" href="css-folder/ajouter-abs-style.css">
    <title>Ajouter un salarié</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = 'deconnexion.php';">Déconnexion</button>
    </div>
    <div class="centeredcase">
        <h1>Ajout d'une absence</h1><br>
        <!--une absence qui vient d'être ajouter est par défaut injustifié (=0)-->

        <form action="enregistrer-abs.php" method="POST">
            <label for="QUi">QUI</label>
            <select name="selection" id="selection"> 
                <?php
                $fichier_section = '../csv-folder/folder-section/'.$_SESSION['section'].'.csv';
                if (($handle = fopen($fichier_section, 'r')) !== FALSE) {
                    // Lire chaque ligne du fichier CSV
                    while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        if (isset($row[7]) && isset($row[0]) && isset($row[1])) {
                            echo "<option value='" . htmlspecialchars($row[7]) . "'>" . htmlspecialchars($row[0]) . " - " . htmlspecialchars($row[1]) . "</option>";
                        }
                    }
                    fclose($handle);
                }
                ?>
            </select>
            <label for="jour">Jour</label><br>
            <input type="number" id="jour" name="jour" min="1" max="31" required><br>
            <label for="mois">Mois</label><br>
            <input type="number" id="mois" name="mois" min="1" max="12" required><br>
            <input type="submit" value="Ajouter absence">
        </form>
    </div>
</body>
</html>