<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

function updateAbsenceStatus($nom, $prenom, $date) {
    $filePath = "../csv-folder/absences-totales.csv";
    $rows = [];

    // Lire le fichier CSV dans un tableau
    if (($handle = fopen($filePath, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            if ($data[0] == $nom && $data[1] == $prenom && $data[2] == $date) {
                $data[3] = "1"; // Modifier le statut en "Justifiée"
            }
            $rows[] = $data;
        }
        fclose($handle);
    } else {
        die("Erreur: Impossible d'ouvrir le fichier $filePath");
    }

    // Écrire les modifications dans le fichier CSV
    if (($handle = fopen($filePath, "w")) !== false) {
        foreach ($rows as $row) {
            fputcsv($handle, $row, ";");
        }
        fclose($handle);
    } else {
        die("Erreur: Impossible d'ouvrir le fichier $filePath en écriture");
    }
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['justifier'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date = $_POST['date'];
    updateAbsenceStatus($nom, $prenom, $date);
    header("Location: gerer-abs.php"); // Recharger la page pour afficher les modifications
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css-folder/gerer-abs-style.css">
    <title>Gérer absences</title>
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
        <h1>Gérer les absences</h1><br>
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            <?php
            $filePath = "../csv-folder/absences-totales.csv";
            if (($handle = fopen($filePath, "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                    echo "<tr>";
                    echo "<td>{$data[0]}</td>";
                    echo "<td>{$data[1]}</td>";
                    echo "<td>{$data[2]}</td>";
                    echo "<td>" . ($data[3] == "0" ? "Injustifiée" : "Justifiée") . "</td>";
                    echo "<td>
                            <form method='POST' action='gerer-abs.php'>
                                <input type='hidden' name='nom' value='{$data[0]}'>
                                <input type='hidden' name='prenom' value='{$data[1]}'>
                                <input type='hidden' name='date' value='{$data[2]}'>
                                <input type='submit' name='justifier' value='Justifiée'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                fclose($handle);
            } else {
                echo "Erreur: Impossible d'ouvrir le fichier $filePath";
            }
            ?>
        </table>
    </div>
</body>
</html>
