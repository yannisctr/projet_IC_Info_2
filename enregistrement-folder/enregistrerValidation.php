<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

// Vérifier si des données ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $date = $_POST["date"];
    $reponse = $_POST["reponse"];
    $profil = $_SESSION['profil'];

    // Déterminer le fichier de destination en fonction de la réponse
    if ($profil == "secretaire") {
        $fichierValidation = "validations_salarie.csv";
    } elseif ($profil == "admin") {
        $fichierValidation = "validations_secretaire.csv";
    } else {
        // Profil non reconnu, rediriger
        header("Location: connexion.php");
        exit;
    }

    // Écrire la validation ou le refus dans le fichier CSV
    $fichier = fopen($fichierValidation, "a+");
    fputcsv($fichier, array($nom, $prenom, $date, $reponse));
    fclose($fichier);

    // Lire le fichier des demandes et supprimer la demande traitée
    $fichierDemandes = "demandes_secretaire.csv"; // Assurez-vous que ce fichier est correct
    $demandes = array();
    if (($handle = fopen($fichierDemandes, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (!($data[0] == $nom && $data[1] == $prenom && $data[2] == $date)) {
                $demandes[] = $data;
            }
        }
        fclose($handle);
    }

    // Réécrire le fichier sans la demande traitée
    $handle = fopen($fichierDemandes, "w");
    foreach ($demandes as $demande) {
        fputcsv($handle, $demande);
    }
    fclose($handle);

    // Afficher un message de succès et rediriger
    echo "Votre réponse a été enregistrée avec succès.<br><br>";
} else {
    // Si aucune donnée n'a été soumise, rediriger vers la page d'accueil
    header("Location: accueil-secretaire.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css-folder/enregistrement.css">
    <title>Validation</title>
</head>
<body>
<p>Si vous souhaitez faire d'autres actions cliquez ici -> <a href="accueil-secretaire.php">ICI</a></p>
</body>
</html>
