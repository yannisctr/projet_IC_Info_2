<head>
    <meta name="author" content="Lina" />
    <link rel="stylesheet" type="text/css" href="styleValiderConges.css" />
    <link rel="shortcut icon" href="images/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
    <img class="logo" src="logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="accueil.html" class="link">Accueil</a>
        <a href="deconnexion.html" class="link">Déconnexion</a>
        
    </div>

    <h1>Validation congés</h1>



</body>
</html>

<?php
$mois= [
    "Janvier", 
    "Fevrier", 
    "Mars",
    "Avril",
    "Mai", 
    "Juin", 
    "Juillet",
    "Aout", 
    "Septembre", 
    "Octobre", 
    "Novembre", 
    "Decembre"
];
echo "<form action='traitementConges.php' method='POST'>";
echo "<table border='1'>";
echo "<tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Date</th>
        <th>Validation</th>
      </tr>";

$file = fopen('demandeconges.csv', 'r');

$cpt = 0;
$time = 0; 
while (($ligne = fgetcsv($file)) !== false) {
    if ($time==0) {
       $time += 1;
    }
    else
    {
        $tampon = explode('-',$ligne[2]);
        $tampon[0] += -1; 
        $mois_du_conge = $mois[$tampon[0]]; 
        echo "<tr>
                <td>$ligne[0]</td>
                <td>$ligne[1]</td>
                <td>{$tampon[1]} $mois_du_conge </td>
                <td>
                    <input type='radio' id='oui$cpt' name='validation[$cpt]' value='oui'>
                    <label for='oui$cpt'>Oui</label>
                    <input type='radio' id='non$cpt' name='validation[$cpt]' value='non'>
                    <label for='non$cpt'>Non</label>
                </td>
              </tr>";
        $cpt++;

    }
   
}

fclose($file);

echo "</table>";
echo "<input type='submit' value='Valider'>";
echo "</form>";
?>

