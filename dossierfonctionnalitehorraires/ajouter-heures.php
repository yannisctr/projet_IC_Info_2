<?php 
    session_start();
?>

<head>
    <meta name="author" content="Lina" />
    <link rel="stylesheet" type="text/css" href="styleAjouterHeures.css" />
    <link rel="shortcut icon" href="images/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
    <img class="logo" src="logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="accueil.html" class="link">Accueil</a>
        <a href="deconnexion.html" class="link">Déconnexion</a>
        
    </div>

    <h1>Ajouter des heures de travail</h1>


</body>
</html>


<?php
//ajout du form en php car il contient bcp de ligne
echo"<form action='enregistrer-heures.php' method='POST'>";
//il y a 52 semaine dans l'année donc il faut renter les infos
//pour ces 52 semaines (qu'on rajouter avec une boucle en php)
for ($i = 1; $i<53 ; $i++) {
    echo "<p> semaine n° $i : </p>"; //affiche le numéro de la semaine
    // les input sont par défaut rempli à 0 sinon c'était trop long à remplir 
    echo "<label>Dimanche</label>";
    echo "<input type='number' id='dimanche$i' name='dimanche$i' min='0' max='24' value='0' required><br>";
    echo "<label>Lundi</label>";
    echo "<input type='number' id='lundi$i' name='lundi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Mardi</label>";
    echo "<input type='number' id='mardi$i' name='mardi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Mercredi</label>";
    echo "<input type='number' id='mercredi$i' name='mercredi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Jeudi</label><br>";
    echo "<input type='number' id='jeudi$i' name='jeudi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Vendredi</label>";
    echo "<input type='number' id='vendredi$i' name='vendredi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Samedi</label>";
    echo "<input type='number' id='samedi$i' name='samedi$i' min='0' max='24' value='0' required><br>";

    
};

echo"<input type='submit' value='Ajouter heures'>";
//fermeture du form
echo"</form>"


?>