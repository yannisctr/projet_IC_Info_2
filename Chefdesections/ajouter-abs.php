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
    <link rel="stylesheet" href="../css-folder/ajouter-abs-style.css">
    <title>Ajouter un salarié</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
        <div class="button-container">
            <button class="b1" type="button" onclick="location.href = 'accueil-section.php';">Accueil</button>
            <button class="b1" type="button" onclick="location.href = 'deconnexion.php';">Déconnexion</button>
        </div>
    </div>
    <div class="centeredcase">
        <h1>Ajout d'une absence</h1><br>
        <!--une absence qui vient d'être ajouter est par défaut injustifié (=0)-->

        <form action="enregistrer-abs.php" method="POST">
            <label for="Nom">Nom</label><br>
            <select name="userId" id="selection" onchange="updateHiddenFields()" required>
                <option value="" disabled selected>Choisir un salarié</option>
                <?php 
                    $fichier_section = fopen("../csv-folder/folder-section/".$_SESSION['section'].".csv",'r');
                    while (($read_data = fgetcsv($fichier_section,1000,";")) !== FALSE) {
                        echo "<option value='{$read_data[7]}' data-nom='{$read_data[0]}' data-prenom='{$read_data[1]}'>{$read_data[0]} {$read_data[1]}</option>";
                    }
                    fclose($fichier_section);
                ?>
            </select>
            <input type="hidden" name="nom" id="nom">
            <input type="hidden" name="prenom" id="prenom">
            <label for="jours">Jour</label><br>
            <input type="number" id="jour" name="jour" min="1" max="31" required>
            <label for="mois">Mois</label><br>
            <input type="number" id="mois" name="mois" min="1" max="12" required>
            <input type="submit" value="Ajouter absence">
        </form>
    </div>
    <script>
        function updateHiddenFields() {
            var select = document.getElementById('selection');
            var selectedOption = select.options[select.selectedIndex];
            document.getElementById('nom').value = selectedOption.getAttribute('data-nom');
            document.getElementById('prenom').value = selectedOption.getAttribute('data-prenom');
        }
    </script>
</body>
</html>
