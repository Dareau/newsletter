<?php include("connection.php"); 
session_start();
?>
<?php
//AJOUT D'UNE CAMPAGNE A LA BDD
    if (isset($_POST['createCampaign']) && $_GET['type'] == 'add')
    {
        /* VALUES */
        $nom=$_POST['name'];
        $id_list = $_POST['select_list'];
        $id_model = $_POST['select_model'];

        $sql = "INSERT INTO campaign
                (campaign_name,id_model,id_contact_list,id_user)
                VALUES ('".utf8_decode($nom)."', '" . utf8_decode($id_model) . "', '" . utf8_decode($id_list) . "', '" . $_SESSION['user'] . "')";
        
        $dbh->exec($sql);
        header('Location: campaigns.php');
    }
    
//SUPPRESSION D'UNE CAMPAGNE DE LA BDD
    if ($_GET['type'] == 'delete')
    {
        /* VALUES */
        $id=$_GET['campaign_id'];
        //Suppression de la campaign
        $sql = "DELETE FROM campaign WHERE campaign_id='". $id . "'";
        $dbh->exec($sql);
        header('Location: campaigns.php');
    }

//EDIT D'UNE CAMPAGNE    
    if($_GET['type'] == 'update')
    {
        $campaign_id=$_POST['id'];
        $campaign_name=$_POST['name'];
        $model_id=$_POST['select_model'];
        $list_id=$_POST['select_list'];
        
        // echo $campaign_id;
        // echo $campaign_name;
        // echo $model_id;
        // echo $list_id;
        
        $sql ="UPDATE campaign 
                SET campaign_name='" . $campaign_name . "', 
                id_model='" . $model_id . "', 
                id_contact_list='" . $list_id . "' 
                WHERE campaign_id='" . $campaign_id . "'";
        $dbh->exec($sql);
        header('Location: campaigns.php');    
    }  
    
//MULTI-ENVOIE D'UN MODELE A UNE LISTE
    $sql = "SELECT * FROM user
            WHERE id='" . $_SESSION['user'] . "'";
    foreach ($dbh->query($sql) as $row)
    {
        $user_login = $row['login'];
        $user_mail = $row['mail'];
    }
    
    if ($_GET['type'] == 'send')
    {
        /*VALUES*/
        $id_model=$_GET['id_model'];
        $list_id=$_POST['list_id'];
        
        //RECUPERATION DES INFOS DU MODEL
        $sql_model_details = "SELECT *
                              FROM model
                              WHERE model_id=". $id_model;
                              
        foreach ($dbh->query($sql_model_details) as $model)
        {
            $model_name=$model['model_name'];
            $model_object=$model['model_object'];
            $model_content=$model['model_content'];
            $model_signature=$model['model_signature'];
        }
        
        //RECUPERATION DE TOUS LES MAILS DE LA LISTE
        $sql_list_mail = "SELECT contact_name, contact_mail, contact_id 
                          FROM contact, appartient, contact_list 
                          WHERE appartient.id_contact_list = contact_list.list_id 
                          AND contact.contact_id = appartient.id_contact 
                          AND contact_list.list_id =". $list_id . " 
                          AND contact.id_user=" . $_SESSION['user'] ." 
                          AND contact_list.id_user=" . $_SESSION['user'];
        
        foreach ($dbh->query($sql_list_mail) as $mail) 
        {
            /* Destinataire (votre adresse e-mail) */
            $to = $mail['contact_mail'];
            $expediteur = $user_mail;
            $expediteur_login = user_login;
            $sujet = $model_object;
            
            /* Construction du message */
            $msg = '***** Votre message *******'."\r\n";
            $msg .= $model_content."\r\n";
            $msg .= '***************************'."\r\n";
            $msg .= $model_signature;
            
            /* En-têtes de l'e-mail */
            $headers = 'From: "' . $expediteur_login . '" <"'.$expediteur.'">'."\r\n\r\n";
            
            /* Envoi de l'e-mail */
            mail($to, $sujet, $msg, $headers);
            header('Location: campaigns.php');
            
            // //----------------------------------------------- 
            // //DECLARE LES VARIABLES 
            // //----------------------------------------------- 
            
            // $destinataire=$mail['contact_mail'];
            // $email_expediteur='toto@tata.fr';
            // $email_reply=$mail['contact_mail'];
            
            // $objet=$model_object;
            // $message_texte=$model_content; 
            
            // //----------------------------------------------- 
            // //GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML 
            // //----------------------------------------------- 

            // $frontiere = '-----=' . md5(uniqid(mt_rand())); 

            // //----------------------------------------------- 
            // //HEADERS DU MAIL 
            // //----------------------------------------------- 
            // $headers = 'From: Nom <"'.$email_expediteur.'">'."\n";  

            // //----------------------------------------------- 
            // //MESSAGE TEXTE 
            // //-----------------------------------------------
            // $message = 'This is a multi-part message in MIME format.'."\n\n"; 

            // $message .= '--'.$frontiere."\n"; 
            // $message .= 'Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
            // $message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
            // $message .= $message_texte."\n\n"; 

            // $message .= '--'.$frontiere."\n"; 

            // if(mail($destinataire,$objet,$message,$headers)) 
            // { 
            //     echo 'Le mail a été envoyé'; 
            // } 
            // else 
            // { 
            //     echo 'Le mail n\'a pu être envoyé'; 
            // } 
            
            }
        //header('Location: campaigns.php');
    }
?>