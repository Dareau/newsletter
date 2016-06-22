<?php include("connection.php"); 

session_start();

//Récupération des informations de l'utilisateur connecté
$sql="SELECT * FROM user WHERE id=".$_SESSION['user'];
foreach ($dbh->query($sql) as $row)
{
    $user_login = $row['login'];
    $user_mail = $row['mail'];
}    
?>
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
    <!--FontAwesome-->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!--ICONE-->
    <link rel="icon" type="image/png" href="img/icon_mail.png" />
    <!-- JS -->
    <script type="text/javascript\" src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div id="wrapper">
        <!-- Barre latérale -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                        Menu d'administration
                </li>
                <li class="important_sidebar">                    
                    <a href="contacts.php"><i class='fa fa-user fa-2'></i>&nbsp;Contacts</a>
                </li>
                <li class="important_sidebar">
                    <a href="groups.php"><i class='fa fa-users fa-2'></i>&nbsp;Groupes</a>
                </li>                
                <li class="important_sidebar">
                    <a href="mails.php"><i class="fa fa-envelope fa-2"></i>&nbsp;Mails</a>
                </li>
                <li>
                    <a href="campaigns.php"><i class="fa fa-flag fa-2"></i>&nbsp;Campagnes</a>
                </li>
                <li>
                    <a href="contact.php"><i class="fa fa-phone fa-2"></i>&nbsp;Nous contacter</a>
                </li>
                <li>
                    <a href='logout.php?logout'><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;Sign Out from <?php echo $user_login; ?></a> 
                </li>
                
            </ul>
            
        </div>
</html>