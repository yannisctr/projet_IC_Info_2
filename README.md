# projet_IC_Info

## Description

Ce projet est une collaboration entre plusieurs membres pour créer un site internet. L'objectif principal est de fournir une wep app. Le projet consiste à permettre en fonction du rôle de l’utilisateur de gérer plus simplement et efficacement les fiches de paie ainsi que les heures de travail des salariés avec une webapp en interne.

## Fonctionnalités

- [ ] Fonctionnalité 1 : pouvoir ajouter / supprimer / modifier un salarié
- [ ] Fonctionnalité 2 : permettre au salarié de proposer une demande de congé et connaitre son emploi du temps
- [ ] Fonctionnalité 3 : pouvoir gerer les abcenses, les heures supplémentaires pour faciliter la gestion RH

## Installation

1. Cloner ce dépôt : `git clone https://github.com/BlRGO/Projet_IC_Info_2.git`
2. Aller dans le répertoire du projet : `cd Projet_IC_Info_2`
3. Installer PHP sur votre machine
4. ouvrir le projet via VSCode et le servir sur votre machine grace a l'extention "PHP Server" ou via le terminal grace a cette ligne de commande "php -S localhost:8080"

## Configuration du Compte Gmail pour PHPMailer

### Prérequis

Pour utiliser PHPMailer avec votre compte Gmail, vous devez activer l'authentification à deux facteurs (2FA) et créer un mot de passe d'application. Cela permet de sécuriser votre compte tout en permettant à des applications tierces, comme PHPMailer, d'envoyer des emails.

### Étapes de Configuration

1. **Activer l'authentification à deux facteurs (2FA) sur votre compte Gmail** :
   - Allez sur [https://myaccount.google.com/](https://myaccount.google.com/).
   - Connectez-vous à votre compte Google.
   - Accédez à la section "Sécurité".
   - Sous "Se connecter à Google", trouvez "Validation en deux étapes" et cliquez sur "Configurer" ou "Gérer".
   - Suivez les instructions à l'écran pour activer la validation en deux étapes (2FA).

2. **Créer un mot de passe d'application** :
   - Une fois l'authentification à deux facteurs activée, retournez à la section "Sécurité" dans votre compte Google.
   - Sous "Se connecter à Google", trouvez "Mots de passe des applications" et cliquez dessus.
   - Si vous y êtes invité, connectez-vous à nouveau pour confirmer votre identité.
   - Dans le menu déroulant "Sélectionner l'application", choisissez "Mail" et dans "Sélectionner l'appareil", choisissez "Ordinateur Windows" ou tout autre appareil correspondant.
   - Cliquez sur "Générer".
   - Google vous fournira un mot de passe d'application. **Copiez ce mot de passe**. Vous ne le verrez qu'une seule fois.

3. **Configurer PHPMailer avec le mot de passe d'application** :
   - Dans votre fichier PHP où vous configurez PHPMailer, remplacez le mot de passe par le mot de passe d'application que vous venez de générer.

   Exemple :
   ```php
   $mail->Username = 'votreadresse@gmail.com';
   $mail->Password = 'votre_mot_de_passe_d_application'; // Utilisez ici le mot de passe d'application


## Utilisation

2. Accéder au site à l'adresse : `http://localhost:8080/connexion.php` ou grace a l'extension VSCode installé précédemment

## Technologies Utilisées

- HTML5
- PHP8
- CSS3
- JavaScript

## Contributeurs

- Chris Decembre ([@ChrisDecembre](https://github.com/ChrisDcbr))
- Lina Grille ([@LinaGrille](https://github.com/LinaGR07))
- Nylan Paillassa ([@NylanPaillassa](https://github.com/Nylan01))
- Yannis Chatir ([@YannisChatir](https://github.com/BlRGO))
