<?php
    // On va utiliser l'espace de nom On indique a PHP
    // qu'on va utiliser phpMailer, Exception, SMTP
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
 // On va inclure les fichiers :
    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
 // On va instancier la class PHPMailer
    $mail = new PHPMailer(true);
 // Pour dire qu'on peut utiliser le protocol SMTP
    $mail -> isSMTP();
  // On doit specifier notre serveur depuis lequel
  // on va envoyer les e-mail
    $mail -> Host = 'smtp.gmail.com';
  // Activer l'authentification, l'envlois de mail
  // necessite une authetification(userName, password)
    $mail -> SMTPAuth = true; 
    $mail -> Username = 'aghilev@gmail.com';
    $mail -> Password = 'nfkbfmmasadlwcqy';
  // Type de criptage
    $mail -> SMTPSecure = 'tls';
    $mail -> Port = 587;
  // Le encodage
    $mail -> CharSet = 'utf-8';
 // @mail depuis laqelle on va envoyer des mail+ nomExpeditor
    $mail -> setFrom('aghilev@gmail.com', 'Ghilev');
  // adresse Destinataire
    $mail -> addAddress('alexghilev78@gmail.com', 'Alexandru');
    // $mail -> addAddress('aghilev@gmail.com', 'Alexandru');
  // Activer l'envoi de mail sous forme HTML
    $mail -> isHTML(true);
  // L'objet de notre mail
    $mail -> Subject = 'Confirmation d\'email';
    $mail -> Body = 'Bonjour, confirmez votre adresse mail';
  // Désactiver le débug
    $mail -> SMTPDebug = 0;
  // l'envois du mail
    if( !$mail) {  //si email n'a pas été envoié
        $message = "Mail non envoyé :-( ";
        echo 'Erreur : '.$mail -> ErrorInfo ;
    } else {   //email envoyé
        $message = "Un email vous a été envoyé avec succes :-) ";
        echo $message; 
    }
?>