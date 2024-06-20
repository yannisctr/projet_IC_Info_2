<?php
session_start();

// Fonction pour lire les données du fichier CSV
function lireCSV($fichier) {
    $data = [];
    if (($handle = fopen($fichier, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

// Fonction pour séparer les valeurs d'une chaîne au format "mois-jour"
function separerValeurs($chaine) {
    return explode('-', $chaine);
}

// Fonction pour obtenir le nom du mois en français
function obtenirNomMois($mois) {
    $mois_noms = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];
    return $mois_noms[intval($mois)];
}

// Fonction pour vérifier et formater les jours consécutifs avec les noms des mois
function formatCongesConsecutifs($dates) {
    $formatted_dates = [];
    
    // Trier les dates par mois et jour
    usort($dates, function($a, $b) {
        list($moisA, $jourA) = separerValeurs($a);
        list($moisB, $jourB) = separerValeurs($b);
        
        if ($moisA == $moisB) {
            return $jourA - $jourB;
        }
        return $moisA - $moisB;
    });

    $start = $dates[0];
    $end = $dates[0];

    // Parcourir les dates pour détecter les périodes consécutives
    for ($i = 1; $i < count($dates); $i++) {
        list($moisStart, $jourStart) = separerValeurs($start);
        list($moisEnd, $jourEnd) = separerValeurs($end);
        list($moisCurrent, $jourCurrent) = separerValeurs($dates[$i]);

        if ($moisCurrent == $moisEnd && $jourCurrent == $jourEnd + 1) {
            // Les jours sont consécutifs, mettre à jour la date de fin
            $end = $dates[$i];
        } else {
            // Les jours ne sont pas consécutifs, ajouter la période au tableau formaté
            if ($start == $end) {
                // Seulement un jour dans la période
                $formatted_dates[] = $jourStart . ' ' . obtenirNomMois($moisStart);
            } else {
                // Plusieurs jours consécutifs dans la période
                $formatted_dates[] = $jourStart . '-' . $jourEnd . ' ' . obtenirNomMois($moisStart);
            }
            // Réinitialiser pour la prochaine période
            $start = $dates[$i];
            $end = $dates[$i];
        }
    }

    // Ajouter la dernière période au tableau formaté
    list($moisStart, $jourStart) = separerValeurs($start);
    list($moisEnd, $jourEnd) = separerValeurs($end);
    if ($start == $end) {
        // Seulement un jour dans la dernière période
        $formatted_dates[] = $jourStart . ' ' . obtenirNomMois($moisStart);
    } else {
        // Plusieurs jours consécutifs dans la dernière période
        $formatted_dates[] = $jourStart . '-' . $jourEnd . ' ' . obtenirNomMois($moisStart);
    }

    // Retourner le tableau formaté des périodes de congé consécutives
    return $formatted_dates;
}

// Lire le fichier CSV
$data = lireCSV($_SESSION['pseudo'].'/congés.csv');

// Obtenir le mois et le jour actuels
$date_actuel = getdate();
$mois_actuel = $date_actuel['mon'];
$jour_actuel = $date_actuel['mday'];

// Tableaux pour les congés passés et futurs
$conges_passe = [];
$conges_suivant = [];

// Parcourir les lignes de données (en commençant à l'indice 1 pour éviter l'en-tête)
for ($index = 1; $index < count($data); $index++) {
    $row = $data[$index];
    foreach ($row as $col) {
        if (!empty($col)) {
            list($mois, $jour) = separerValeurs($col);

            if ($mois < $mois_actuel || ($mois == $mois_actuel && $jour < $jour_actuel)) {
                $conges_passe[] = $col;
            } else {
                $conges_suivant[] = $col;
            }
        }
    }
}

// Formater les jours de congé pour les périodes consécutives
$conges_passe_formatte = formatCongesConsecutifs($conges_passe);
$conges_suivant_formatte = !empty($conges_suivant) ? formatCongesConsecutifs($conges_suivant) : [];

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="ModifConge.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="../img-package/logo_alb.png">
        <title>Congés</title>
    
    </head>
    <body>
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">

        <nav>
            <a href="../Infopage.php" class="link">Accueil</a>
            <a href="mesInfos.php" class="link">Mes infos</a>
            <a href="../deconnexion.php" class="link">Déconnexion</a>  
        </nav>
    
        <table id="TableCP">
            <tr><th>Congés Passés</th></tr>
            <?php foreach ($conges_passe_formatte as $periode): ?>
                <tr><td><?= htmlspecialchars($periode) ?></td></tr>
            <?php endforeach; ?>
        </table>

    
        <table id="TableCV">
            <tr><th>Congés à Venir</th></tr>
            <?php foreach ($conges_suivant_formatte as $periode): ?>
                <tr><td><?= htmlspecialchars($periode) ?></td></tr>
            <?php endforeach; ?>
        </table>
                
        <form action="traitementconge.php" method="post">
            <label for=""> Posez un jour de congé : </label>
            <input type="date" name="date">
            <input type="submit" value="submit">
        </form>

    </body>
</html>
