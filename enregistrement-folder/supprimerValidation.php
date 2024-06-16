<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

// Vérifier si des données ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $profil = $_SESSION['profil'];

    // Déterminer le fichier de destination en fonction du profil
    if ($profil == "salarie") {
        $fichier = "validations_salarie.csv";
    } elseif ($profil == "secretaire") {
        $fichier = "validations_secretaire.csv";
    } else {
        header("Location: connexion.php");
        exit;
    }

    // Lire le fichier et supprimer la validation
    $rows = array();
    if (($handle = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[2] != $date) {
                $rows[] = $data;
            }
        }
        fclose($handle);
    }

    // Réécrire le fichier sans la validation supprimée
    $handle = fopen($fichier, "w");
    foreach ($rows as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);

    header("Location: accueil-salarie.php");
    exit;
}
?>
