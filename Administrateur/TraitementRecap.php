<?php
session_start(); 
header('Content-Type: text/html; charset=utf-8');
require('../Salariés/pdfgeneration/fpdf.php'); // Chemin vers la bibliothèque FPDF

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

// Fonction pour générer le PDF
function genererPDFConges($data, $mois_actuel,$data_recap) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $texte = 'Exemple avec des caractères accentués : é, à, è, ç';
    $texte_converti = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texte);

    // Titre
    $nom_mois = obtenirNomMois($mois_actuel);
    $pdf->Cell(0, 10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Récapitulatif des Congés pour '.$nom_mois.''), 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0,10,"Nom : ".$data_recap[$mois_actuel][0],0,1,);
    $pdf->Cell(0,10,"".iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Prénom')." : ".$data_recap[$mois_actuel][1],0,1,);
    $pdf->Cell(0,10,"Type de Contrat : ".$data_recap[$mois_actuel][2],0,1,);
    $pdf->Ln();

    // Table des congés
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Congé ce mois'), 1,0,'C');
    $pdf->Ln();
    $compteur =0; 

    // Parcourir les données et filtrer les congés du mois actuel
    foreach ($data[1] as $index => $row) {
       // print_r(separerValeurs($row));
            $tableau = [];
                $tableau = separerValeurs($row);
               
                if ($tableau[0] == $mois_actuel) {
                    $pdf->Cell(50, 10, "".$tableau[1]." ".$nom_mois."", 1,0,'C');
                    $pdf->Ln();
                    $compteur += 1;
            
                }
            
        
    }
    //print_r($data_recap[$mois_actuel][1]);
    $pdf->Ln(10); 
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0,10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Total Lissé :'),0,1,'C');
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0,10,$data_recap[$mois_actuel][5]." heures",0,1,'C');
    $pdf->Ln(3); 
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0,10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Heures Supplémentaires : '),0,1,'C');
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0,10,$data_recap[$mois_actuel][6]." heures",0,1,'C');
    $pdf->Ln(3); 
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0,10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Congés payés'),0,1,'C');
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0,10,$compteur." jours",0,1,'C');
    $pdf->Ln(3); 
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0,10,"Absecences :",0,1,'C');
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(0,10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "justifiée(s) : ")." ".$data_recap[$mois_actuel][7]." jours",0,1,'C');
    $pdf->Cell(0,10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "non justifiée(s) : ")." ".$data_recap[$mois_actuel][8]." jours",0,1,'C');

    $pdf->Output();
    // Sauvegarder le PDF
   // $pdf->Output('D', "Recapitulatif_Conges_$nom_mois.pdf");
}

// Lire le fichier CSV
$data = lireCSV('../Salariés/'.$_POST['nomSalarie'].'/congés.csv');
$data_recap = lireCSV('../Salariés/'.$_POST['nomSalarie'].'/RecapMensuel.csv');

// Obtenir le mois actuel
$date_actuel = getdate();
$mois_actuel = $date_actuel['mon'];

// Générer le PDF avec les congés du mois actuel
genererPDFConges($data, $mois_actuel,$data_recap);

?>
