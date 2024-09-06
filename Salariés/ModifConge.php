<?php
session_start();

// Fonction pour lire une ligne spécifique du fichier CSV
function lireLigneCSV($fichier, $numero_ligne) {
    $ligne = null;
    if (($handle = fopen($fichier, "r")) !== FALSE) {
        $compteur = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($compteur == $numero_ligne) {
                $ligne = $data;
                break;
            }
            $compteur++;
        }
        fclose($handle);
    }
    return $ligne;
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
    
    if (empty($dates)) {
        return $formatted_dates;
    }

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

    for ($i = 1; $i < count($dates); $i++) {
        list($moisStart, $jourStart) = separerValeurs($start);
        list($moisEnd, $jourEnd) = separerValeurs($end);
        list($moisCurrent, $jourCurrent) = separerValeurs($dates[$i]);

        if ($moisCurrent == $moisEnd && $jourCurrent == $jourEnd + 1) {
            $end = $dates[$i];
        } else {
            if ($start == $end) {
                $formatted_dates[] = $jourStart . ' ' . obtenirNomMois($moisStart);
            } else {
                $formatted_dates[] = $jourStart . '-' . $jourEnd . ' ' . obtenirNomMois($moisStart);
            }
            $start = $dates[$i];
            $end = $dates[$i];
        }
    }

    list($moisStart, $jourStart) = separerValeurs($start);
    list($moisEnd, $jourEnd) = separerValeurs($end);
    if ($start == $end) {
        $formatted_dates[] = $jourStart . ' ' . obtenirNomMois($moisStart);
    } else {
        $formatted_dates[] = $jourStart . '-' . $jourEnd . ' ' . obtenirNomMois($moisStart);
    }

    return $formatted_dates;
}

// Vérifier si le fichier CSV existe et lire la deuxième ligne
$fichier_csv = $_SESSION['pseudo'] . '/congés.csv';
$deuxieme_ligne = lireLigneCSV($fichier_csv, 1);

$conges_passe = [];
$conges_suivant = [];

if ($deuxieme_ligne === null || empty(array_filter($deuxieme_ligne))) {
    $pas_de_conges = true;
} else {
    $pas_de_conges = false;
    
    $date_actuel = getdate();
    $mois_actuel = $date_actuel['mon'];
    $jour_actuel = $date_actuel['mday'];

    // Lire toutes les lignes du fichier CSV
    $handle = fopen($fichier_csv, "r");
    $premiere_ligne = true;
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($premiere_ligne) {
            $premiere_ligne = false;
            continue;
        }
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
    fclose($handle);

    $conges_passe_formatte = formatCongesConsecutifs($conges_passe);
    $conges_suivant_formatte = formatCongesConsecutifs($conges_suivant);
}
?>

<!DOCTYPE html>
<html lang="fr">
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
        <a href="Infopage.php" class="link">Accueil</a>
        <a href="mesInfos.php" class="link">Mes infos</a>
        <a href="../deconnexion.php" class="link">Déconnexion</a>  
    </nav>

    <?php if ($pas_de_conges): ?>
        <p>Aucun congé n'a été enregistré.</p>
    <?php else: ?>
        <?php if (!empty($conges_passe_formatte)): ?>
            <table id="TableCP">
                <tr><th>Congés Passés</th></tr>
                <?php foreach ($conges_passe_formatte as $periode): ?>
                    <tr><td><?= htmlspecialchars($periode) ?></td></tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <?php if (!empty($conges_suivant_formatte)): ?>
            <table id="TableCV">
                <tr><th>Congés à Venir</th></tr>
                <?php foreach ($conges_suivant_formatte as $periode): ?>
                    <tr><td><?= htmlspecialchars($periode) ?></td></tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
            
    <form action="traitementconge.php" method="post">
        <label for="date_conge">Posez un jour de congé : </label>
        <input type="date" id="date_conge" name="date_conge" required>
        <input type="submit" value="Soumettre">
    </form>

</body>
</html>