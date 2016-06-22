<?php
session_start();

//Déconnexion de l'utilisateur
if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
else if(isset($_SESSION['user'])!="")
{
    header("Location: contacts.php");
}

if(isset($_GET['logout']))
{
    session_destroy();
    unset($_SESSION['user']);
    header("Location: index.php");
}
?>