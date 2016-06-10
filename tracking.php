<?php include("connection.php"); 
session_start();
?>
<?php
    $sql = "INSERT INTO tracking
            VALUES ('250','0')";
    $dbh->exec($sql);
?>