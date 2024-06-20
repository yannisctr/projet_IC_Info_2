<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css-folder/ajouter-salarie-style.css">
    <title>Ajouter un salarié</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = 'deconnexion.php';">Déconnexion</button>
      
        
    </div>
    <div class="centeredcase">
        <div class="forms-container">
            <div class="form-container">
        <h1>Ajout d'un salarié</h1><br>
                <form action="enregistrement-folder/enregistrer-salarie.php" method="POST">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="contrat">Type de contrat :</label>
                        <input type="text" id="contrat" name="contrat" required>
                    </div>
                    <div class="form-group">
                        <label for="statut"> Statut :</label>
                        <select name="statut" id="statut">
                            <option value="Salarié">Salarié</option>
                            <option value="Administrateur">Administrateur</option>
                            <option value="Secretaire">Secrétaire</option>
                            <option value="ChefDeSection">Chef de section</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="section"> Section</label>
                        <?php 
                        echo "<select name='section'>"; 

                        $start_row = 1; 
                        $i = 0; 
                        if (($file = fopen("csv-folder/Liste_sections.csv","r")) !== FALSE ) 
                        {
                            while (($read_data = fgetcsv($file,1000,";")) !== FALSE) 
                            {
                                if ($start_row != 1) {
                                    echo "<option value = ".$read_data[0].">".$read_data[0]."</option>";
                                }
                                $start_row++; 
                                $i = 1 + $i; 
                            }
                            fclose($file);
                        }
                        echo "<option value ='Tout'>Tout</option>";
                        echo "</select>"; 
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="adresse" required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Numéro :</label>
                        <input type="tel" id="numero" name="numero" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <input type="submit" value="Ajouter salarié">
                </form>
            </div>
            <div class="form-container">
        <h1>Ajout d'une section</h1><br>

                <form action="rajoutsection.php" method="post">
                    <label for="nouv_section">Rajoutez une section</label>
                    <input type="text" name="nouv_section" id="nouv_section">
                    <input type="submit" value="Ajouter">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
