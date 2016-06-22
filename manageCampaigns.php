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
                VALUES ('".utf8_decode(addslashes($nom))."', '" . utf8_decode($id_model) . "', '" . utf8_decode($id_list) . "', '" . $_SESSION['user'] . "')";
        
        try{
            $dbh->exec($sql);
        }
        //Gestion des erreurs
        catch(PDOException $ex){ 
            header('Location: campaigns.php?error=true'); 
        }
        if(empty($ex))
        {
            header('Location: campaigns.php?error=false');     
        }
    }
    
//SUPPRESSION D'UNE CAMPAGNE DE LA BDD
    if ($_GET['type'] == 'delete')
    {
        /* VALUES */
        $id=$_GET['campaign_id'];
        //Suppression de la campaign
        $sql = "DELETE FROM campaign WHERE campaign_id='". $id . "'";
        $dbh->exec($sql);

        //Suppression du tracking
        $sql2 = "DELETE FROM tracking WHERE id_campaign='". $id . "'";
        $dbh->exec($sql2);
        header('Location: campaigns.php');
    }

//EDIT D'UNE CAMPAGNE    
    if($_GET['type'] == 'update')
    {
        /* VALUES */
        $campaign_id=$_POST['id'];
        $campaign_name=$_POST['name'];
        $model_id=$_POST['select_model'];
        $list_id=$_POST['select_list'];
        
        $sql ="UPDATE campaign 
                SET campaign_name='" . addslashes($campaign_name) . "', 
                id_model='" . $model_id . "', 
                id_contact_list='" . $list_id . "' 
                WHERE campaign_id='" . $campaign_id . "'";
        try{
            $dbh->exec($sql);
        }
        //Gestion des erreurs
        catch(PDOException $ex){ 
            header('Location: campaigns.php?error=true'); 
        }
        if(empty($ex))
        {
            header('Location: campaigns.php');     
        }   
    }  
    
//MULTI-ENVOIE D'UN MODELE A UNE LISTE

    /*
        Récupération des information de l'utilisateur grâce à la variable de session.
        Ces informations vont permettre de renseigner l'expediteur lors de l'envoi des mails
    */
    $sql = "SELECT * FROM user
            WHERE id='" . $_SESSION['user'] . "'";
    foreach ($dbh->query($sql) as $row)
    {
        //Assignation des valeurs à des variables / Même valeur pour tous les mails à envoyer
        $user_login = $row['login'];
        $user_mail = $row['mail'];
    }
    /*
        Condition d'execution du script, lors de l'envoi de la campagne, l'URL du formulaire a plusieurs paramètres :
            - ?type=send : l'action que l'on veut réaliser
            - id_model : l'id du modèle de la campagne
            - id_campaign : l'id de la campagne
    */
    if ($_GET['type'] == 'send')
    {
        /* Récupération des deux id dans l'URL somumise par le formulaire */
        $id_campaign=$_GET['id_campaign'];
        $id_model=$_GET['id_model'];

        /* Récupération de l'id de la liste de contact de la campagne */
        $list_id=$_POST['list_id'];
        
        /*
            Récupération des informations du modèle en base de données.
            Ces informations vont nous permettre de construire notre mail.
        */
        $sql_model_details = "SELECT *
                              FROM model
                              WHERE model_id=". $id_model;
                              
        foreach ($dbh->query($sql_model_details) as $model)
        {
            //Assignation des valeurs à des variables / Même valeur pour tous les mails à envoyer
            $model_name=$model['model_name'];
            $model_object=$model['model_object'];
            $model_content=$model['model_content'];
            $model_signature=$model['model_signature'];
        }
        /* Chaque campagne ne s'envoi qu'une fois, ici, nous mettons à jour notre campagne pour la signaler comme "envoyée". */
        $sql_envoye = "UPDATE campaign
                        SET envoye='1'
                        WHERE campaign_id='" . $id_campaign . "'";
        $dbh->exec($sql_envoye);
        /* Récupération de tous les contactes de la liste de la campagne. */
        $sql_list_mail = "SELECT contact_name, contact_mail, contact.contact_id 
                          FROM contact , appartient, contact_list 
                          WHERE appartient.id_contact_list = contact_list.list_id 
                          AND contact.contact_id = appartient.id_contact 
                          AND contact_list.list_id =". $list_id . " 
                          AND contact.id_user=" . $_SESSION['user'] ." 
                          AND contact_list.id_user=" . $_SESSION['user'];
        
        foreach ($dbh->query($sql_list_mail) as $mail) 
        {
            /*
                Chaque résultat de la requête représente un mail à envoyer.
                La table tracking répertorie chaque mail envoyé d'une campagne et suit l'ouverture de celui ci.
                Nous créons donc ici les lignes de suivi de chaque mail envoyés.
            */
            $sql = "INSERT INTO tracking (id_contact, id_campaign, ouvert)
                    VALUES ('" . $mail['contact_id'] . "','" . $id_campaign . "','0')";
            $dbh->exec($sql);

            /*
                Nous utilisons l'ensemble des variables créés précédemment afin de fabriquer le mail qui va être envoyée.
            */
            $to = $mail['contact_mail']; //mail de notre contacte
            $expediteur = $user_mail; //mail de l'utilisateur, créateur de la newsletter
            $expediteur_login = $user_login; //login de l'utilisateur
            $sujet = $model_object; //objet du modèle séléctionné
            
            /* Construction du message */
            $msg = "";
            $msg .= $model_content."<br/>"; //contenu du modèle
            $msg .= $model_signature; //signature du modèle
            /*
                Notre système de tracking repose sur un spypixel dissimulé dans le mail. 
                Une fois le mail ouvert, cette image se charge et une fonction php à l'URL : http://www.appliweb.lan/newsletter/tracking.php s'execute.
                Cette fonction reçoit en paramètre l'id du contacte ainsi que l'id de la campagne.
            */
            $msg .= '<img src="http://www.appliweb.lan/newsletter/tracking.php?id_campaign=' . $id_campaign . '&id_contact=' . $mail['contact_id'] . '" alt="" width="1" height="1" border="0"/>';
            
            /* En-têtes de l'e-mail */
            $headers = "";
            $headers = 'From: "' . $expediteur_login . '" <"'.$expediteur.'">'."\n";
            $headers .= 'Content-Type: text/html; charset=\"iso-8859-1\"' . "\n"; //Permet de renseigner que le message doit être interpreté en HTML
            
            /* Envoi de l'e-mail */
            mail($to, $sujet, $msg, $headers);
            /* Retour à la page de campagne */
            header('Location: campaigns.php');  
        }
    }
?>