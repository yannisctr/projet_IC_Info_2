<?php
session_start(); 
$pseudo = $_SESSION['pseudo'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mois']) && isset($_POST['annee'])) {
        $mois = (int)$_POST['mois'];
        $annee = (int)$_POST['annee'];
        
        $start_row = 1;
        $output = '';

        if (($file = fopen("RecapMensuel.csv", "r")) !== FALSE) {
            while (($read_data = fgetcsv($file, 1000, ",")) !== FALSE) {
                if ($start_row == $mois+1) {
                    $output .="<h1> Ce mois :</h1>";
                    $output .= "<h3 style='grid-area: 2/1/2/3; justify-self: center'> Total lissé :</h3>";
                    $output .= "<p style='grid-area: 3/1/3/3; justify-self: center'>".$read_data[5]." heures</p>";
                    $output .= "<h3 style='grid-area: 4/1/4/3; justify-self: center'> Heures supplementaires :</h3>";
                    $output .= "<p style='grid-area: 5/1/5/3; justify-self: center'>".$read_data[6]." heures</p>";
                    $output .= "<h3 style='grid-area: 6/1/6/3; justify-self: center'>Congés payés :</h3>";
                    $output .= "<p style='grid-area: 7/1/7/3; justify-self: center'>".$read_data[3]." jours</p>";
                    $output .= "<h3 style='grid-area: 8/1/8/3; justify-self: center'> Absences :</h3>";
                    $output .= "<p style='grid-area: 9/1/9/1; justify-self: center'> justifiés :</p>";
                    $output .= "<p style='grid-area: 10/1/10/1; justify-self: center'> non justifiés :</p>";
                    $output .= "<p style='grid-area: 9/2/9/2'>".$read_data[7]."</p>";
                    $output .= "<p style='grid-area: 10/2/10/2'>".$read_data[8]."</p>";
                    break;
                }
                $start_row++;
            }
            fclose($file);
        }
        echo $output;
    } else {
        echo 'Données du mois ou de l\'année non reçues.';
    }
} else {
    echo 'Requête invalide.';
}
?>
