<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="author" content="Lina" />
    <link rel="stylesheet" type="text/css" href="../css-folder/styleEnregistrerHeures.css" />
    <link rel="shortcut icon" href="../img-package/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
    <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
    <div class="tête">
        <a href="accueil.html" class="link">Accueil</a>
        <a href="deconnexion.html" class="link">Déconnexion</a>
        
    </div>
    
<?php

//maintenant, il faut récupérer les infos pour chaque semaine
//les afficher dans la page
//et les enregistrer dans le csv 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // partie pour afficher le haut du tableau
        echo "<table border='1'>";
        echo "<tr>
                <th>Semaine</th>
                <th>Dimanche</th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>

              </tr>";

              $userId = $_POST['userId'];
            $path = '../Salariés/'.$userId.'/horaires.csv'; 
            //echo($path);
        // ouverture du fichier CSV en mode écriture
        $file = fopen('../Salariés/'.$userId.'/horaires.csv', 'a+');
      
        // ecriture les en-têtes dans le fichier CSV
        fputcsv($file, ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']);

        for ($i = 1; $i <= 52; $i++) {
            // recup des infos pour la ième semaine
            $dimanche = htmlspecialchars($_POST['dimanche'.$i]);
            $lundi = htmlspecialchars($_POST['lundi'.$i]);
            $mardi = htmlspecialchars($_POST['mardi'.$i]);
            $mercredi = htmlspecialchars($_POST['mercredi'.$i]);
            $jeudi = htmlspecialchars($_POST['jeudi'.$i]);
            $vendredi = htmlspecialchars($_POST['vendredi'.$i]);
            $samedi = htmlspecialchars($_POST['samedi'.$i]);
            

            // partie affichage
            echo "<tr>
                    <td>$i</td>
                    <td>$dimanche</td>
                    <td>$lundi</td>
                    <td>$mardi</td>
                    <td>$mercredi</td>
                    <td>$jeudi</td>
                    <td>$vendredi</td>
                    <td>$samedi</td>
                    
                  </tr>";

            // ecriture les données dans le fichier CSV
            fputcsv($file, [ $dimanche,$lundi, $mardi, $mercredi, $jeudi, $vendredi, $samedi]);
        }

        echo "</table>";

        // fermeture fichier CSV
        fclose($file);
    }
?>
</body>
</html>
