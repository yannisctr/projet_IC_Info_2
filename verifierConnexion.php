<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['mot_de_passe'])) {
	$identifiant = $_POST['login'];
	$motdepasse = $_POST['mot_de_passe'];
	if (substr($identifiant, 0, 1) === 'l') //Salarie
	{
		if(($handle = fopen("csv-folder/salarie.csv", "r"))) {
			while(($data = fgetcsv($handle, 1000, ";"))) {
				if($data[7] === $identifiant && $data[8] === $motdepasse){
					$_SESSION['profil'] = 'salarie';
					$_SESSION['nom'] = $data[0];
					$_SESSION['prenom'] = $data[1];
					$_SESSION['pseudo'] = $data[7];
					fclose($handle);
					header('Location: Salariés/Infopage.php');
					exit();
				}
			}
			fclose($handle);
		}else{
			echo "Mot de passe ou identifiant incorrect";
			header('Location: connexion.php');
		}
		
	} elseif(substr($identifiant, 0, 1) === 'm')  //Administrateur
	{
		
		if(($handle = fopen("csv-folder/administrateur.csv", "r"))) {
			while(($data = fgetcsv($handle, 1000, ";"))) {
				if($data[7] === $identifiant && $data[8] === $motdepasse){
					$_SESSION['profil'] = 'admin';
					$_SESSION['nom'] = $data[0];
					$_SESSION['prenom'] = $data[1];
					$_SESSION['pseudo'] = $data[7];
					fclose($handle);
					header('Location: Administrateur/accueil-admin.php');
					exit();
				}
			}
			fclose($handle);
		}else{
			echo "Mot de passe ou identifiant incorrect";
			header('Location: connexion.php');
		}
	}

	elseif (substr($identifiant, 0, 1) === 'e') //Chef de Section
	{
		if(($handle = fopen("csv-folder/chefdesection.csv", "r"))) { 
			while(($data = fgetcsv($handle, 1000, ";"))) {
				if($data[7] === $identifiant && $data[8] === $motdepasse){
					$_SESSION['profil'] = 'salarie';
					$_SESSION['nom'] = $data[0];
					$_SESSION['prenom'] = $data[1];
					$_SESSION['pseudo'] = $data[7];
					$_SESSION['section'] = $data[3];
					fclose($handle);
					header('Location: Chefdesections/accueil-section.php');
					exit();
				}
			}
			fclose($handle);
		}else{
			echo "Mot de passe ou identifiant incorrect";
			header('Location: connexion.php');
		}

	}

	elseif (substr($identifiant, 0, 1) === 'c') //Secretaire
	{
		if(($handle = fopen("csv-folder/secretaire.csv", "r"))) {
			while(($data = fgetcsv($handle, 1000, ";"))) {
				if($data[7] === $identifiant && $data[8] === $motdepasse){
					$_SESSION['profil'] = 'salarie';
					$_SESSION['nom'] = $data[0];
					$_SESSION['prenom'] = $data[1];
					$_SESSION['pseudo'] = $data[7];
					fclose($handle);
					header('Location: Secretaires/accueil-secretaire.php');
					exit();
				}
			}
			fclose($handle);
		}else{
			echo "Mot de passe ou identifiant incorrect";
			header('Location: connexion.php');
		}
	}

}
if ($identifiant === 'admin' && $motdepasse === 'admin') {
	$_SESSION['pseudo']= 'm';

	header('Location: Administrateur/accueil-admin.php');
					exit();
}
else{
	header('Location: connexion.php');
}