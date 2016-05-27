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
        $content=$_POST['content'];
        $signature=$_POST['signature'];  
        
        $sql = "INSERT INTO model (model_name, model_object, model_content, model_signature, user_id) 
                VALUES ( '".utf8_decode($nom)."','".utf8_decode($object)."','".utf8_decode($content)."','".utf8_decode($signature)."', '" . $_SESSION['user'] . "')";
        // use exec() because no results are returned
        $dbh->exec($sql);
        header('Location: mails.php');
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
                SET model_name='" . $model_name . "', 
                model_object='" . $model_object . "', 
                model_content='" . $model_content . "', 
                model_signature='" . $model_signature . "'
                WHERE model_id='" . $model_id . "'";
        $dbh->exec($sql);
        header('Location: mails.php');    
    }  
?>