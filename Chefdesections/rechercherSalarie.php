<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

?>

<html>
<head>
    <meta name="author" content="Lina" />
    <link rel="stylesheet" type="text/css" href="../css-folder/styleRecherche.css" />
    <link rel="shortcut icon" href="../images/logo.png">
    <title>Rechercher un salarié</title>
</head>
<body>
    <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
    <div class="tête">
        <?php
        $profil = $_SESSION['profil'];
        if ($profil == "admin") {
            echo "<a href='accueil-admin.php' class='link'>Accueil</a>";
        } else {
            echo "<a href='accueil-secretaire.php' class='link'>Accueil</a>";
        }
        ?>
        <a href="deconnexion.php" class="link">Déconnexion</a>
        
    </div>

    <h1>Recherche du salarié</h1>

    <div class="zoneRecherche">
        <div class="recherche">
            <label for="search">
                <img src="../img-package/loupe - Copie.svg" alt="Rechercher"  class="loupe-icon">
            </label>
            <form method="POST" id="searchForm">
                <input type="text" name="search" id="search" placeholder="Rechercher un salarié">
                
            </form>
        </div>

    </div>

    <div class="zoneResultat">
        <h3 >Nom,  Prénom</h3>


        <br>

        <div id="result" class="result">
        </div>
    </div>



    <script type="text/javascript" src="recherche.js"></script>
</body>
</html>


