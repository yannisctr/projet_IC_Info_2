<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

$demandes = array();
if (($handle = fopen("csv-folder/demandes_secretaire.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $demandes[] = $data;
    }
    fclose($handle);
}
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
        <button class="b2"><a href="../ajouter-salarie.php"><img src="img-package/user-2.png" alt="Ajouter un salarié"><span>Ajouter un salarié</span></a></button>
        <button class="b2"><a href="../modifier-salarie.php"><img src="img-package/user-10.png" alt="Modifier un salarié"><span>Modifier un salarié</span></a></button>
        <button class="b2"><a href="../supprimer-salarie.php"><img src="img-package/user-3.png" alt="Supprimer un salarié"><span>Supprimer un salarié</span></a></button>
        <button class="b2"><a href="rechercherSalarie.php"><img src="img-package/user-13.png" alt="Voir les informations des salariés"><span>Voir les informations des salariés</span></a></button>
    </div>

    <div class="demandes">
    <?php foreach ($demandes as $demande): ?>
        <div class="demande">
            <?php echo $demande[0] . " " . $demande[1] . " a demandé un congé le " . $demande[2]; ?>
            <form method="post" action="../enregistrement-folder/enregistrerValidation.php">
                <input type="hidden" name="nom" value="<?php echo $demande[0]; ?>">
                <input type="hidden" name="prenom" value="<?php echo $demande[1]; ?>">
                <input type="hidden" name="date" value="<?php echo $demande[2]; ?>">
                <select name="reponse">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
                <button type="submit">Envoyer</button>
            </form>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
