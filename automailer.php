<?php

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['profil'])) {
    header("Location: connexion.php");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function shouldSendEmail($filePath) {
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (isset($data[3]) && $data[3] == '0') {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

function sendEmails($recipients, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'votreadresse@gmail.com';
        $mail->Password   = 'votre_mot_de_passe';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('votreadresse@gmail.com', 'Votre Nom');

        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        echo 'Les emails ont été envoyés avec succès.';
    } catch (Exception $e) {
        echo "L'email n'a pas pu être envoyé. Erreur Mailer: {$mail->ErrorInfo}";
    }
}

// Définir le chemin du fichier CSV
$filePath = 'chemin/vers/votre/absences-totales.csv';

// Vérifier si un email doit être envoyé
if (shouldSendEmail($filePath)) {
    $recipients = [
        'destinataire1@example.com',
        'destinataire2@example.com',
        'destinataire3@example.com'
    ];

    $subject = 'Notification d\'absence';
    $body = '<h1>Attention</h1><p>Il y a des absences signalées aujourd\'hui.</p>';

    sendEmails($recipients, $subject, $body);
} else {
    echo 'Aucun email n\'a été envoyé. Aucune absence détectée.';
}
?>
