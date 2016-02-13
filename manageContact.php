<?php include("connection.php"); 
session_start();
?>
<?php 
     //----------------------------------------------- 
     //DECLARE LES VARIABLES 
     //----------------------------------------------- 

     $destinataire=$_POST['destinataire'];
     $email_expediteur='hostmaster@appliweb.lan'; 
     $email_reply='hostmaster@appliweb.lan';

     $message_texte='Bonjour,'."\n\n".'Voici un message au format texte'; 
     $message_html='<html> 
     <head> 
     <title>Titre</title> 
     </head> 
     <body>Test de message</body> 
     </html>'; 

     //----------------------------------------------- 
     //GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML 
     //----------------------------------------------- 

     $frontiere = '-----=' . md5(uniqid(mt_rand())); 

     //----------------------------------------------- 
     //HEADERS DU MAIL 
     //----------------------------------------------- 

     $headers = 'From: "Nom" <'.$email_expediteur.'>'."\n"; 
     $headers .= 'Return-Path: <'.$email_reply.'>'."\n"; 
     $headers .= 'MIME-Version: 1.0'."\n"; 
     $headers .= 'Content-Type: multipart/alternative; boundary="'.$frontiere.'"'; 

     //----------------------------------------------- 
     //MESSAGE TEXTE 
     //----------------------------------------------- 
     $message = 'This is a multi-part message in MIME format.'."\n\n"; 

     $message .= '--'.$frontiere."\n"; 
     $message .= 'Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
     $message .= $message_texte."\n\n"; 

     //----------------------------------------------- 
     //MESSAGE HTML 
     //----------------------------------------------- 
     $message .= '--'.$frontiere."\n";
     $message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n"; 
     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
     $message .= $message_html."\n\n"; 

     $message .= '--'.$frontiere."\n"; 

     if(mail($destinataire,'Sujet',$message,$headers)) 
     { 
          echo 'Le mail a été envoyé'; 
     } 
     else 
     { 
          echo 'Le mail n\'a pu être envoyé'; 
     } 
?>