
<head>
    <meta name="author" content="Lina" />
    <link rel="stylesheet" type="text/css" href="styleAjouterHeures.css" />
    <link rel="shortcut icon" href="images/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
 

    <h1>Ajouter des heures de travail</h1>


</body>
</html>


<?php
//ajout du form en php car il contient bcp de ligne
echo"<form action='../enregistrement-folder/enregistrer-heures.php' method='POST'>";
echo "<input type ='hidden' name='userId' value=".$pseudo." >";
//il y a 52 semaine dans l'année donc il faut renter les infos
//pour ces 52 semaines (qu'on rajouter avec une boucle en php)
for ($i = 1; $i<53 ; $i++) {
    echo "<p> semaine n° $i : </p>"; //affiche le numéro de la semaine
    // les input sont par défaut rempli à 0 sinon c'était trop long à remplir 
    echo "<label>Dimanche</label>";
    echo "<input type='text' id='dimanche$i' name='dimanche$i' min='0' max='24' value='0' required><br>";
    echo "<label>Lundi</label>";
    echo "<input type='text' id='lundi$i' name='lundi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Mardi</label>";
    echo "<input type='text' id='mardi$i' name='mardi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Mercredi</label>";
    echo "<input type='text' id='mercredi$i' name='mercredi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Jeudi</label><br>";
    echo "<input type='text' id='jeudi$i' name='jeudi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Vendredi</label>";
    echo "<input type='text' id='vendredi$i' name='vendredi$i' min='0' max='24' value='0' required><br>";
    echo "<label>Samedi</label>";
    echo "<input type='text' id='samedi$i' name='samedi$i' min='0' max='24' value='0' required><br>";
    

    
};

echo"<input type='submit' value='Ajouter heures'>";
//fermeture du form
echo"</form>"


?>