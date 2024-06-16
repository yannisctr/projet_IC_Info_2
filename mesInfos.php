<head>
    <meta name="author" content="Lina" />
    <link rel="shortcut icon" href="images/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
    <img class="logo" src="logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="accueilVide.html" class="link">Accueil</a>
        <a href="mesInfos.php" class="link">Mes infos</a>
        <a href="deconnexion.html" class="link">Déconnexion</a>
        
    </div>

    <h1>Mes infos</h1>
    <p class="remarque">Si certaines informations vous concernant ne sont plus à pour, merci de les modifier <a href="modifMesInfos.php" class="link">ici</a></p>



</body>
</html>
<?php

//ouverture du fichier avec les infos de tous le monde
$file = fopen('personnes.csv', 'r');

//A MODIFIER : avec la session et tout, on aura déjà le pseudo de la personne
$pseudo = 'mmartin';

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
