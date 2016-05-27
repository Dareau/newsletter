<?php
include("connection.php");

session_start();

if(isset($_POST['btn-login']))
{
    $login = $_POST['login'];
    $upass = $_POST['pass'];

    
    
    $sql = "SELECT * FROM user WHERE login='" . $login . "'";
    foreach ($dbh->query($sql) as $row)
    {   
        if($row['password']==md5($upass))
        {
            $_SESSION['user'] = $row['id'];
            header("Location: contacts.php");
        }
    }
    echo '<div style="margin-bottom:-30px;" class="alert alert-danger" role="alert">Erreur : Informations incorrectes </div>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de presentation des services">
    <meta name="author" content="HNN">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <!-- Perso CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- JS -->
    <script type="text/javascript\" src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login</title>
    </head>
    <body>
        <center>
            <div id="login-form">
            <form method="post">
                    <table align="center" width="30%" border="0">
                        <tr>
                            <td><input type="text" name="login" placeholder="Login" required /></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="pass" placeholder="Password" required /></td>
                        </tr>
                        <tr>
                            <td><button type="submit" name="btn-login">Sign In</button></td>
                        </tr>
                        <tr>
                            <td><a href="register.php">Sign Up Here</a></td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </body>
</html>
