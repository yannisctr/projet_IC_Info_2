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
    <link rel="stylesheet" href="../css-folder/enregistrement.css">
    <title>Enregistrer un salarié</title>
</head>
<body>
    <div class="header">
        <img class="logo" src="../img-package/logo_alb.png" alt="logo-alb">
        <button class="b1" type="button" onclick="location.href = '../Administrateur/accueil-admin.php';">Accueil</button>
    </div>
    <?php
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $contrat = $_POST["contrat"];
    $premiereLettre = substr($prenom, 0, 1);
    $pseudo = $premiereLettre . $nom;
    $mdp1 = "";
    $mdp2 = "";
    $section = $_POST["section"];
    $adresse = $_POST["adresse"];
    $numero = $_POST["numero"];
    $AdresseMail = $_POST["email"];
    $statut = $_POST["statut"];

    $entete = array(array("Nom", "Prénom", "Pseudo", "Mot de passe"));

    function generate_password() {
        $chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        $password = '';
        for ($i = 0; $i < 8; $i++) {
            $password .= $chars[array_rand($chars)];
        }
        return $password;
    }

    function creerCSV_cache($nomfichier, $donnees) {
        $fichier = fopen($nomfichier, 'w');
        if ($fichier === false) {
            die("Impossible d'ouvrir le fichier $nomfichier");
        }
        foreach ($donnees as $ligne) {
            fputcsv($fichier, $ligne);
        }
        fclose($fichier);
    }

    $mdp1 = generate_password();
    $mdp2 = $mdp1;

    function creerCSV($statut, $donnees, $pseudo) {
        if ($statut == 'Salarié') {
            $tab = array(array("Absence", "justifie (0 : injustifé 1: justifie)"));
            $filePath = "../Salariés/";
            $nomFichier = $filePath . $pseudo;
            creerCSV_cache($nomFichier . "/InformationsPersos.csv", $donnees);
            creerCSV_cache($nomFichier . "/Absences.csv", $tab);
            $tab = array(
                array("Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam")
            );
            creerCSV_cache($nomFichier . "/horaires.csv", $tab);
            $tab = array(array("Nom", "Prenom", "Type de Contrat", "Congés Posés (jours)", "Congés restant (jours)", "Total réel (heures)", "Heures supplementaires", "Absence justifiée", "Absence non justifiée"));
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            $tab[] = array("".$donnees[0][0]."","".$donnees[0][1]."","".$donnees[0][2]."",0,0,0,0,0,0);
            creerCSV_cache($nomFichier . "/RecapMensuel.csv", $tab);
            $tab = array(array("congés1", "congés2", "congés3", "congés4", "congés5", "congés6", "congés7", "congés8", "congés9", "congés10", "congés11", "congés12", "congés13", "congés14", "congés15", "congés16", "congés17", "congés18", "congés19", "congés20", "congés21", "congés22", "congés23", "congés24", "congés25", "congés26", "congés27", "congés28", "congés29", "congés30"));
            creerCSV_cache($nomFichier . "/congés.csv", $tab);
        } elseif ($statut == 'Administrateur') {
            $filePath = "../Administrateur/";
            $nomFichier = $filePath . $pseudo;
            creerCSV_cache($nomFichier . "/InformationsPersos.csv", $donnees);
        } elseif ($statut == 'Secretaire') {
            $filePath = "../Secretaires/";
            $nomFichier = $filePath . $pseudo;
            creerCSV_cache($nomFichier . "/InformationsPersos.csv", $donnees);
            $tab = array(array("congés1", "congés2", "congés3", "congés4", "congés5", "congés6", "congés7", "congés8", "congés9", "congés10", "congés11", "congés12", "congés13", "congés14", "congés15", "congés16", "congés17", "congés18", "congés19", "congés20", "congés21", "congés22", "congés23", "congés24", "congés25", "congés26", "congés27", "congés28", "congés29", "congés30"));
            creerCSV_cache($nomFichier . "/congés.csv", $tab);
        } else {
            $filePath = "../Chefdesections/";
            $nomFichier = $filePath . $pseudo;
            creerCSV_cache($nomFichier . "/InformationsPersos.csv", $donnees);
        }
    }

    function CreerDossier($pseudo, $statut) {
        if ($statut == 'Salarié') {
            $filePath = "../Salariés/";
        } elseif ($statut == 'Administrateur') {
            $filePath = "../Administrateur/";
        } elseif ($statut == 'Secretaire') {
            $filePath = "../Secretaires/";
        } else {
            $filePath = "../Chefdesections/";
        }

        $dossier = $filePath . $pseudo;

        if (!file_exists($dossier)) {
            // Créer le dossier
            if (mkdir($dossier, 0777, true)) {
                // echo 'Le dossier a été créé avec succès.';
            } else {
                echo 'Erreur lors de la création du dossier.';
            }
        } else {
            echo 'Le dossier existe déjà.';
        }
    }

    function pseudo($pseudo, $statut) {
        if ($statut == 'Salarié') {
            $filePath = "../csv-folder/salarie.csv";
            $pseudo = 'l' . $pseudo;
        } elseif ($statut == 'Administrateur') {
            $filePath = "../csv-folder/administrateur.csv";
            $pseudo = 'm' . $pseudo;
        } elseif ($statut == 'Secretaire') {
            $filePath = "../csv-folder/secretaire.csv";
            $pseudo = 'c' . $pseudo;
        } else //Chef de Section du coup
        {
            $filePath = "../csv-folder/chefdesection.csv";
            $pseudo = 'e' . $pseudo;
        }
        $var = rand(1, 99);
        if (($handle = fopen($filePath, "r"))) {
            while (($data = fgetcsv($handle, 1000, ";"))) {
                
                if ($pseudo == $data[7]) {
                    $pseudo = $pseudo . $var;
                }
            }
            fclose($handle);
        } else {
            die("Erreur: Impossible d'ouvrir le fichier $filePath");
        }
        return $pseudo;
    }

    function creerDossierSiNonExistant($chemin) {
        if (!file_exists($chemin)) {
            if (!mkdir($chemin, 0777, true)) {
                die('Erreur lors de la création du dossier : ' . $chemin);
            }
        }
    }

    function ecrire($infos, $statut) {
        if ($statut == 'Salarié') {
            //echo 'Rentre dans la fonction';
            $filePath = "../csv-folder/folder-section/";
            $fileName = $filePath . $infos[0][3] . ".csv";

            creerDossierSiNonExistant($filePath);

            if (!file_exists($fileName)) {
                //echo "Le fichier n'existe pas";
                $tab = array(array('Nom','Prenom','Type De Contrat','Section','Adresse','Numero','Adressemail','identifiant','mdp','statut'));
                creerCSV_cache($fileName, $tab);
            }

            $file = fopen($fileName, "a+");
            foreach ($infos as $ligne) {
                if (fputcsv($file, $ligne, ";") === false) {
                    fclose($file);
                    die("Erreur: Impossible d'écrire dans le fichier " . $infos[0][3] . ".csv");
                }
            }
            fclose($file);

            $filePath = "../csv-folder/salarie.csv";
        } elseif ($statut == 'Administrateur') {
            $filePath = "../csv-folder/administrateur.csv";
        } elseif ($statut == 'Secretaire') {
            $filePath = "../csv-folder/secretaire.csv";
        } else {
            $filePath = "../csv-folder/chefdesection.csv";
        }

        $file = fopen($filePath, "a+");
        if ($file === false) {
            die("Erreur: Impossible d'ouvrir le fichier $filePath");
        }
        foreach ($infos as $ligne) {
            if (fputcsv($file, $ligne, ";") === false) {
                fclose($file);
                die("Erreur: Impossible d'écrire dans le fichier $filePath");
            }
        }
        fclose($file);
    }

    function afficherTableau2D() {
        $filePath = "../csv-folder/salarie.csv";
        $row = 0;
        if (($handle = fopen($filePath, "r"))) {
            echo "<table border='1'>";
            while (($data = fgetcsv($handle, 1000, ";"))) {
                echo "<tr>";
                if ($row == 0) {
                    echo "<td>Nom</td>";
                    echo "<td>Prénom</td>";
                    echo "<td>Pseudo</td>";
                    echo "<td>Mot de passe</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>$data[0]</td>";
                    echo "<td>$data[1]</td>";
                    echo "<td>$data[7]</td>";
                    echo "<td>$data[8]</td>";
                    echo "</tr>";
                    $row += 1;
                } else {
                    echo "<td>$data[0]</td>";
                    echo "<td>$data[1]</td>";
                    echo "<td>$data[7]</td>";
                    echo "<td>$data[8]</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            fclose($handle);
        } else {
            die("Erreur: Impossible d'ouvrir le fichier $filePath");
        }
    }

    function afficher_mot_de_passe($pseudo, $mdp) {
        echo "<br>";
        echo "ATTENTION : le login et le mot de passe qui vont s'afficher ne s'afficheront qu'une seule fois et ici seulement. Veiller à les noter";
        echo " et à les donner à l'employé en question.<br>";
        echo "<br>";
        echo "<table border='1'>";
        echo "<tr>";
        echo "<td>Pseudo</td>";
        echo "<td>Mot de passe</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>$pseudo</td>";
        echo "<td>$mdp</td>";
        echo "</tr>";
        echo "</table>";
    }

    $pseudo = pseudo($pseudo, $statut);
    $mdp1 = md5($mdp1);
    $infos = array(
        array($nom, $prenom, $contrat, $section, $adresse, $numero, $AdresseMail, $pseudo, $mdp1, $statut)
    );
    //print_r($infos[0][3]);
    ecrire($infos, $statut);

    CreerDossier($pseudo, $statut);
    creerCSV($statut, $infos, $pseudo);

    // afficherTableau2D();
    afficher_mot_de_passe($pseudo, $mdp2);
    ?>

   

    <?php 
    if (substr($_SESSION['pseudo'],0,1) === 'm') {
       echo " <button><a href='../Administrateur/accueil-admin.php'>Retour</a></button>"; 
    }
    else
    {
        echo " <button><a href='../Secretaires/accueil-secretaire.php'>Retour</a></button>"; 
    }
    if (substr($pseudo,0,1)==='l') {
       include '../ajouter-heures.php';
    }
    ?>
</body>
</html>