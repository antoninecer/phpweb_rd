<?php
require_once 'inc/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name && $email && $message) {
        $subject = "Nová zpráva z kontaktního formuláře od $name";

        $htmlBody = "<p><strong>Jméno:</strong> $name</p>" .
                    "<p><strong>E-mail:</strong> $email</p>" .
                    "<p><strong>Zpráva:</strong><br>" . nl2br($message) . "</p>";

        $plainBody = "Jméno: $name\nE-mail: $email\nZpráva:\n$message";

        $success1 = sendEmail('antoninecer@gmail.com', 'Antonín Ečer', $subject, $htmlBody, $plainBody);
        $success2 = sendEmail('honza.perina@gmail.com', 'Jan Peřina', $subject, $htmlBody, $plainBody);

        if ($success1 && $success2) {
            header('Location: contact.php?sent=1');
            exit;
        } else {
            header('Location: contact.php?sent=0');
            exit;
        }
    } else {
        header('Location: contact.php?sent=0');
        exit;
    }
} else {
    header('Location: contact.php');
    exit;
}
