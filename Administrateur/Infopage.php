<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="author" content="Chris" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Infopage.css" />
    <link rel="shortcut icon" href="img/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
    <img class="logo" src="img/logo_alb.png" alt="logo-alb">
    
    <nav>
        <a href="accueil-admin.php" class="link">Accueil</a>
        <a href="../deconnexion.php" class="link">Déconnexion</a>  
    </nav>

    <div class="calendar-box">
        <div class="calendar"> 
            <h2 id="mois"> </h2>
            <div class="semaine">
                    <div>Dim</div>
                    <div>Lun</div>
                    <div>Mar</div>
                    <div>Mer</div>
                    <div>Jeu</div>
                    <div>Ven</div>
                    <div>Sam</div>
            </div>
            <div id="ligne1"> </div>
            <div id="ligne2"></div>
            <div id="ligne3"> </div>
            <div id="ligne4"> </div>
            <div id="ligne5"> </div>
            <div id="ligne6"> </div>
            <button id="prev" ></button>
            <button id="next"></button>
        </div>
    </div>
    <div class="infotext">
        <h1> Ce mois :</h1>
     <?php 
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $num_mois = idate('m');
            $start_row = 1; 

            if (($file = fopen("../Salariés/" . $id . "/RecapMensuel.csv", "r")) !== FALSE) {
                while (($read_data = fgetcsv($file, 1000, ",")) !== FALSE) {
                    if ($start_row == $num_mois + 1) { 
                        echo "<h3 style='grid-area: 2/1/2/3; justify-self: center'> Total lissé :</h3>";
                        echo "<p style='grid-area: 3/1/3/3; justify-self: center'>" . $read_data[5] . " heures</p>"; 
                        echo "<h3 style='grid-area: 4/1/4/3; justify-self: center'> Heures supplementaires :</h3>";
                        echo "<p style='grid-area: 5/1/5/3; justify-self: center'>" . $read_data[6] . " heures</p>";
                        echo "<h3 style='grid-area: 6/1/6/3; justify-self: center'>Congés payés :</h3>";
                        echo "<p style='grid-area: 7/1/7/3; justify-self: center'>" . $read_data[3] . " jours</p>";
                        echo "<h3 style='grid-area: 8/1/8/3; justify-self: center'> Absences :</h3>";
                        echo "<p style='grid-area: 9/1/9/1; justify-self: center'> justifiés :</p>";
                        echo "<p style='grid-area: 10/1/10/1; justify-self: center'> non justifiés :</p>";
                        echo "<p style='grid-area: 9/2/9/2'>" . $read_data[7] . "</p>";
                        echo "<p style='grid-area: 10/2/10/2'>" . $read_data[8] . "</p>";
                        break; 
                    }
                    $start_row++; 
                }
                fclose($file);
            }
        } else {
            echo "<p>Erreur : ID du salarié non spécifié.</p>";
        }
    ?>
    </div>
   
    <h3 style="grid-area: 2/1/2/1; justify-self : center; align-self: end;">Congés :</h3>
    <div class="jauge-boite">
        <div id="jauge"></div>
    </div>
    <div id="utilise"></div>
    <div id="slash">/</div>
    <div id="totaux">30</div>
    
    <div id="boutons"> 
        <?php
            if (isset($_GET['id'])) {
                echo "<a href='supprimer_salarie.php?id=" . urlencode($_GET['id']) . "'>Supprimer</a>"; 
            }
        ?>
           <form action="TraitementRecap.php" method="post">
        <?php
          echo '<input type="hidden" name="nomSalarie" id="nomSalarie" value="' . $_GET['id']. '">';
          ?>
       
    
        <input type="submit" value="Recapitulatif du mois ">
    </form>

    </div>

<script src="Infopage.js"></script>
</body>
</html>
