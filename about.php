<?php include("header.php"); 
//session_start();

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
?>
<!-- PAGE A PROPOS -->
<head>
    <title>A propos</title>
</head>         
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><i class="fa fa-info-circle fa-5"></i>&nbsp;Qui sommes nous ?</h1>
                        <h1>DES PUTAINS DE THUGS LIFE<h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
