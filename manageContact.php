<?php include("connection.php"); 
session_start();
?>
<?php 
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