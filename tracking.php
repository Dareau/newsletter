<?php include("connection.php"); 
session_start();
?>
<?php
// UPDATE LIGNE OUVERT
if(isset($_GET['id_campaign']) && isset($_GET['id_contact']))
{
    $sql = "UPDATE tracking
            SET ouvert='1'
            WHERE id_campaign='" . $_GET['id_campaign'] . "'
            AND id_contact='" . $_GET['id_contact'] . "'";
    $dbh->exec($sql);    
}
?>