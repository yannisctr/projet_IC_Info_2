<?php
    session_start();
?>
<html>
<head>
    <link rel="stylesheet" href="css-folder/enregistrement.css">
    <title>Mes Informations</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = 'mesInfos.php';">Mes infos</button>
        <button class="b1" type="button" onclick="location.href = 'deconnexion.php';">Déconnexion</button>
    </div>

    <h1>Mes infos</h1>
    <p>Si certaines informations vous concernant ne sont plus à pour, merci de les modifier <a href="modifMesInfos.php" class="link">ici</a></p>



</body>
</html>
<?php

//ouverture du fichier avec les infos de tous le monde
$file = fopen('csv-folder/salarie.csv', 'r');


$pseudo = $_SESSION['pseudo'];

while (($ligne = fgetcsv($file, 0, ';')) !== false) {

    if (isset($ligne[7]) && $ligne[7] == $pseudo) {
        
        echo " 
        <div class='mesInfos'>
        <p>Prénom : $ligne[1] </p><br>
        <p>Nom : $ligne[0] </p><br>
        <p>Contrat : $ligne[2] </p><br>
        <p>Sport : $ligne[3] </p><br>
        <p>Adresse : $ligne[4] </p><br>
        <p>Tel : $ligne[5] </p><br>
        <p>Mail : $ligne[6] </p><br>
        <p>Identifiant : $ligne[7] </p><br>
        </div>
        ";
        break;
    }
}


fclose($file); //fermeture du fichier

?>
