<?php

//CONNEXION BDD LOCALE (EASY PHP)
// $hostname='localhost';
// $username='root';
// $password='';

//CONNEXION BDD RESEAU PERSONNEL
$hostname='localhost';
$username='root';
$password='root';


try 
{
    $dbh = new PDO("mysql:host=$hostname;dbname=newsletterdb",$username,$password);
    $dbh->exec("SET CHARACTER SET utf8");

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
    catch(PDOException $e)
{
	echo "Erreur";
	echo $e->getMessage();
}

?> 