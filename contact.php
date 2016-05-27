<?php include("header.php"); 
//session_start();

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
?>

<head>
    <title>Nous contacter</title>
</head>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <h1><i class="fa fa-phone fa-5"></i>&nbsp;Nous contacter</h1>
                        <form class="form-horizontal" method="POST" action="manageContact.php">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmaildest" class="col-sm-2 control-label">dest(temp)</label>
                                <div class="col-sm-10">
                                    <input name="emaildest" type="email" class="form-control" id="inputEmaildest" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputObjet" class="col-sm-2 control-label">Objet</label>
                                <div class="col-sm-10">
                                    <input name="objet" type="text" class="form-control" id="inputObjet" placeholder="Objet" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textareaMessage" class="col-sm-2 control-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea name="message" rows="7" class="form-control" id="textareaMessage" placeholder="Message"required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default btn-lg btn-block">Envoyer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
