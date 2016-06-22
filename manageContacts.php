<?php include("connection.php"); 
session_start();
?>
<?php
//AJOUT D'UN CONTACT A LA BDD
    if (isset($_POST['createContact']) && $_GET['type'] == 'add')
    {
        /* VALUES */
        $id_contact = uniqid();
        $nom=$_POST['name'];
        $mail=$_POST['mail'];   
        $sql = "INSERT INTO contact (contact_id, contact_mail, contact_name, id_user) 
                VALUES ('" . $id_contact . "', '".utf8_decode($mail)."','".utf8_decode($nom)."', '" . $_SESSION['user'] . "')";
        try
        {
            $dbh->exec($sql);
        }
        //Gestion des erreurs
        catch(PDOException $ex)
        { 
            header('Location: contacts.php?error=true'); 
        }
        if(empty($ex))
        {
            header('Location: contacts.php?error=false');     
        }
    }
//SUPPRESSION D'UN CONTACT DANS LA BDD
    if ($_GET['type'] == 'delete')
    {
        /* VALUES */
        $id=$_GET['contact_id'];
        //Suppression du contact
        $sql = "DELETE FROM contact 
                WHERE contact_id='". $id ."'";
        $dbh->exec($sql);
        //Suppression dans la table appartient
        $sql = "DELETE FROM appartient 
                WHERE id_contact='" . $id . "'";
        $dbh->exec($sql);
        header('Location: contacts.php');
    }
//EDIT D'UN CONTACT    
    if(isset($_POST['updateContact']) && $_GET['type'] == 'updateContact')
    {
        $id_list=$_GET['id_list'];
        $id_contact=$_POST['id'];
        $name=$_POST['name_contact'];
        $mail=$_POST['mail_contact'];
  
        $sql2 ="UPDATE contact 
                SET contact_name='" . $name . "', contact_mail='" . $mail . "' 
                WHERE contact_id='" . $id_contact . "'";
        try
        {
            $dbh->exec($sql2);
        }
        //Gestion des erreurs
        catch(PDOException $ex)
        { 
            header('Location: contacts.php?error=true'); 
        }
        if(empty($ex))
        {
            header('Location: contacts.php?error=false');     
        }
    }  
//IMPORT FICHIER CSV
    if(isset($_POST['importer']) && $_GET['type'] == 'importer')
    {
        if ($_FILES['csv']['size'] > 0) 
        { 
            //Récupération du fichier CSV
            $file = $_FILES['csv']['tmp_name']; 
            $handle = fopen($file,"r");
            $i=0;
            
            //Boucle parcourant le fichier CSV
            while ($data = fgetcsv($handle,1000,",","'")) 
            {
                //GET DATA FROM CSV 
                if($data[0])
                {
                    $contact_name = addslashes($data[0]);                    
                    $contact_mail = addslashes($data[1]);                    
                    $contact_mail_without_semilicon = explode(";", $contact_mail);                               
                    
                    $search1 = $dbh->prepare("SELECT * 
                                              FROM contact 
                                              WHERE contact_mail='" . $contact_mail_without_semilicon[0] . "'");
                    $search1->execute() or die(print_r($search1->errorInfo()));
                    $result = $search1->fetch(PDO::FETCH_ASSOC);
                    
                    //Si l'utilisateur existe
                    if($result)
                    {
                        //Existe déjà
                        foreach($_POST['radio_groups_name'] as $valeur => $id)
                        {
                            //On vérifie que les liens n'existent pas déjà
                            $search2 = $dbh->prepare("SELECT * 
                                                      FROM appartient 
                                                      WHERE id_contact='" . $result['contact_id'] . "' AND id_contact_list='" . $id . "'");
                            $search2->execute() or die(print_r($search2->errorInfo()));
                            
                            if($search2->fetch())
                            {
                                //S'il existe, on ne fait rien
                            }
                            else
                            {
                                //Sinon, on le créer                                   
                                $sql4 = "INSERT INTO appartient (id_contact, id_contact_list) 
                                         VALUES ('" . $result['contact_id'] . "','" . $id . "')";
                                $dbh->exec($sql4);                             
                            }
                                                
                        }                    
                    }
                    //Si l'utilisateur n'existe pas
                    else
                    {
                        //On créer les liens de l'utilisateur avec les groupes dans la table appartient
                        $id_contact = uniqid();
                        foreach($_POST['radio_groups_name'] as $valeur => $id)
                        { 
                            $sql1 = "INSERT INTO appartient (id_contact, id_contact_list) VALUES 
                                ( 
                                    '" . $id_contact . "',
                                    '" . $id . "'
                                )
                            ";
                            $dbh->exec($sql1);
                        }
                        //On créer l'utilisateur
                        $sql2 = "INSERT INTO contact (contact_id, contact_name, contact_mail, id_user) VALUES
                            (   '" . $id_contact . "',
                                '".$contact_name."', 
                                '".$contact_mail_without_semilicon[0]."',
                                '" . $_SESSION['user'] . "' 
                            ) 
                        ";
                        $dbh->exec($sql2);
                    }
                }
            };
        }
        header('Location: contacts.php');
    }
?>