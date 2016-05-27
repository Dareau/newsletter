<?php include("connection.php"); 
session_start();
?>
<?php 
     //----------------------------------------------- 
     //DECLARE LES VARIABLES 
     //----------------------------------------------- 
     
     //$destinataire='adminmail';
    //  $destinataire=$_POST['emaildest'];
    //  $email_expediteur=$_POST['email']; 
    //  $email_reply='hostmaster@appliweb.lan';
    //  $objet=$_POST['objet'];

    //  $message_texte=$_POST['message']; 

    //  //----------------------------------------------- 
    //  //GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML 
    //  //----------------------------------------------- 

    //  $frontiere = '-----=' . md5(uniqid(mt_rand())); 

    //  //----------------------------------------------- 
    //  //HEADERS DU MAIL 
    //  //----------------------------------------------- 

    //  $headers = 'From: "Nom<"'.$email_expediteur.'">'."\n"; 
    //  $headers .= 'Return-Path: <'.$email_reply.'>'."\n"; 
    //  $headers .= 'MIME-Version: 1.0'."\n"; 
    //  $headers .= 'Content-Type: multipart/alternative; boundary="'.$frontiere.'"'; 

    //  echo "CECI EST LE HEADER " . $headers;
    //  //----------------------------------------------- 
    //  //MESSAGE TEXTE 
    //  //----------------------------------------------- 
    //  $message = 'This is a multi-part message in MIME format.'."\n\n"; 

    //  $message .= '--'.$frontiere."\n"; 
    //  $message .= 'Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
    //  $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
    //  $message .= $message_texte."\n\n"; 

    //  $message .= '--'.$frontiere."\n";
     
     
     
     
     
     
    /* Destinataire (votre adresse e-mail) */
    $to = $_POST['emaildest'];
    $expediteur = $_POST['email'];
    $sujet = $_POST['objet'];
    
    /* Construction du message */
    $msg  = 'Bonjour,'."\r\n\r\n";
    $msg .= 'Ce mail a été envoyé depuis monsite.com par nous même' . "\r\n\r\n";
    $msg .= 'Voici le message qui vous est adressé :'."\r\n";
    $msg .= '***************************'."\r\n";
    $msg .= $_POST['message']."\r\n";
    $msg .= '***************************'."\r\n";
    
    /* En-têtes de l'e-mail */
    $headers = 'From: bitch <"'.$expediteur.'">'."\r\n\r\n";
    
    /* Envoi de l'e-mail */
    mail($to, $sujet, $msg, $headers);

    //  echo "CECI EST LE MESSAGE " . $message;
    //  if(mail($destinataire,$objet,$message,$headers)) 
    //  { 
    //       echo 'Le mail a été envoyé'; 
    //  } 
    //  else 
    //  { 
    //       echo 'Le mail n\'a pu être envoyé'; 
    //  } 
?>