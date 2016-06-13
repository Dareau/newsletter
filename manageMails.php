<?php include("connection.php"); 
session_start();
?>
<?php       
//AJOUT D'UN MODEL A LA BDD
    if (isset($_POST['createModel']) && $_GET['type'] == 'add')
    {
        /* VALUES */
        $nom=$_POST['name'];
        $object=$_POST['object'];
        $content=$_POST['rte1'];
        $signature=$_POST['signature'];

        // echo $nom;
        // echo $object;
        // echo addslashes($content);
        // echo $signature;


        $sql = "INSERT INTO model (model_name, model_object, model_content, model_signature, user_id) 
                VALUES ( '".utf8_decode(addslashes($nom))."','".utf8_decode(addslashes($object))."','".utf8_decode(addslashes($content))."','".utf8_decode(addslashes($signature))."', '" . $_SESSION['user'] . "')";
        // use exec() because no results are returned        
        try{
            $dbh->exec($sql);
        }
        catch(PDOException $ex){ 
            header('Location: mails.php?error=true'); 
        }
        if(empty($ex))
        {
            header('Location: mails.php?error=false');     
        }
    }
//SUPPRESSION D'UN MODEL DANS LA BDD
    if ($_GET['type'] == 'delete')
    {
        /* VALUES */
        $id=$_GET['model_id'];
        //Suppression du model
        $sql = "DELETE FROM model WHERE model_id='". $id ."'";
        $dbh->exec($sql);
        //Suppression de toutes les campagnes correspondantes
        $sql = "DELETE FROM campaign WHERE id_model='" . $id . "'";
        $dbh->exec($sql);
        header('Location: mails.php');
    }
//EDIT D'UN MODEL    
    if($_GET['type'] == 'update')
    {
        $model_id=$_GET['model_id'];
        $model_name=$_POST['name'];
        $model_object=$_POST['object'];
        $model_content=$_POST['content'];
        $model_signature=$_POST['signature'];
        
        $sql ="UPDATE model 
                SET model_name='" . addslashes($model_name) . "', 
                model_object='" . addslashes($model_object) . "', 
                model_content='" . addslashes($model_content) . "', 
                model_signature='" . addslashes($model_signature) . "'
                WHERE model_id='" . $model_id . "'";
            
        try
        {
            $dbh->exec($sql);
        }
        catch(PDOException $ex)
        { 
            header('Location: mails.php?error=true'); 
        }
        if(empty($ex))
        {
            header('Location: mails.php');     
        }    
    }  
?>