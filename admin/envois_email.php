<?php
  // On indique a PHP qu'on va utiliser phpMailer, Exception, SMTP
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
 // On va inclure les fichiers :
  require 'communs/PHPMailer/src/Exception.php';
  require 'communs/PHPMailer/src/PHPMailer.php';
  require 'communs/PHPMailer/src/SMTP.php';
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
  $mail -> Username = 'webtesttestapp@gmail.com';
  $mail -> Password = 'caiizzjrwxmwdpvw';
 // Type de criptage
  $mail -> SMTPSecure = 'tls';
  $mail -> Port = 587;
 // Le encodage
  $mail -> CharSet = 'utf-8';
 // @mail depuis laqelle on va envoyer des mail+ nomExpeditor
  $mail -> setFrom('webtesttestapp@gmail.com', 'test_smtp');
  // adresse Destinataire
  $mail -> addAddress($_POST['email'], 'Alexandru');
  // Activer l'envoi de mail sous forme HTML
  $mail -> isHTML(true);

  // L'objet de notre mail
  $mail -> Subject = 'Confirmation email';
  $mail -> Body = 'Afin de valider votre @email merci de cliquer sur ce lien : 
    <a href="http://localhost/webcms/verif_email.php?token='.$token.'&email='.$_POST['email'].'" >
      Confirmer votre email
    </a> ';    
  // Désactiver le débug
    $mail -> SMTPDebug = 0;
  // l'envois du mail
  if( !$mail -> send()) {  //si email n'a pas été envoié
    $message = "Mail non envoyé :-( Erreur : ".$mail -> ErrorInfo ;
    echo $message;
  } else {   //email envoyé
    $message = "Un email vous a été envoyé pour confirmer votre adresse email"; 
  }
?>