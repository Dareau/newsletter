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

    //  $headers = 'From: Nom<"'.$email_expediteur.'">'."\n"; 
    //  $headers .= 'Return-Path: <""'.$email_reply.'">'."\n"; 
    //  $headers .= 'MIME-Version: 1.0'."\n"; 
    //  $headers .= 'Content-Type: multipart/alternative; boundary="'.$frontiere.'"'; 

    //  //----------------------------------------------- 
    //  //MESSAGE TEXTE 
    //  //----------------------------------------------- 
    //  $message = 'This is a multi-part message in MIME format.'."\n\n"; 

    //  $message .= '--'.$frontiere."\n"; 
    //  $message .= 'Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
    //  $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
    //  $message .= $message_texte."\n\n"; 

    //  $message .= '--'.$frontiere."\n";

    //  if(mail($destinataire,$objet,$message,$headers)) 
    //  { 
    //       echo 'Le mail a été envoyé'; 
    //  } 
    //  else 
    //  { 
    //       echo 'Le mail n\'a pu être envoyé'; 
    //  } 
     
     
     
    $sql = "SELECT * FROM user
            WHERE id='" . $_SESSION['user'] . "'";
    foreach ($dbh->query($sql) as $row)
    {
        $user_login = $row['login'];
        $user_mail = $row['mail'];
    }
     
     
    /* Destinataire (votre adresse e-mail) */
    $to = 'adminmail@newsletter.com';
    $expediteur = 'adminmail@newsletter.com';
    $sujet = $_POST['objet'];
    
    // /* Construction du message */
    $msg .= $_POST['message']."<br/>";
    $msg .= '<img src="http://www.appliweb.lan/newsletter/tracking.php" alt="" width="0" height="0" border="0"/><br/>';
    
    /* En-têtes de l'e-mail */
    $headers = 'From:"' . $user_login . '" <"'.$expediteur.'">'."\n";
    $headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"' . "\n";
    
    /* Envoi de l'e-mail */
    mail($to, $sujet, $msg, $headers);
    header('Location: contact.php');
    
?>