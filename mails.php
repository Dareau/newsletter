<?php include("header.php"); 
//session_start();

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
?>
<?php
if(!empty($_GET['model_id']))
{
    $sql = "SELECT * FROM model WHERE model_id=" . $_GET['model_id'];
    foreach ($dbh->query($sql) as $row)
    {
        $model_name = $row['model_name'];
        $model_object = $row['model_object'];
        $model_content = $row['model_content'];
        $model_signature = $row['model_signature'];
    }
}
    ?>
<head>
    <script>
        function confirmDelete(modelId)
        {
            if (confirm("Vous êtes sur le point de supprimer un modèle. Continuer ?") == true) 
            {
                document.location.href="manageMails.php?type=delete&model_id=" + modelId;
            }
        }
    </script>
    <title>Mes Mails</title>
</head>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><i class="fa fa-envelope fa-5"></i>&nbsp;Mails</h1>
                    </div>
                    <div class="groups-container">
                        <h3 class="col-md-6">Mes modèles</h3>
                        <h3 class="col-md-6">Ajouter un modèle</h3>
                        <!--Affichage de la liste des model -->
                        <div class="col-md-6 div-mail">
                            <table class="col-md-12 table table-hover table-design">
                                <?php 
                                    $sql = "SELECT model_name, model_id 
                                            FROM model 
                                            WHERE user_id=" . $_SESSION['user'];
                                    foreach ($dbh->query($sql) as $row)
                                    {
                                        echo "
                                            <tr>
                                                <td style='visibility: hidden; position:absolute'>" . $row["model_id"] . "</td>
                                                <td>
                                                    <i class='fa fa-envelope fa-2'></i>
                                                </td>
                                                <td>
                                                    <label id='row-list-" . $row['model_id'] . "'>" . $row['model_name'] . "</label>
                                                </td>
                                                <td>
                                                    <a style='color: black;cursor: pointer' title='Modifier' href='mails.php?model_id=". $row["model_id"] . "'>
                                                        <i class='fa fa-cog fa-2'></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a style='color: black;cursor: pointer' onclick='confirmDelete(\"" . $row["model_id"] . "\")' title='Supprimer' >
                                                        <i class='fa fa-trash-o fa-2'></i>
                                                    </a>
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </table>
                        </div>
                        <!--Affichage de la liste des contact de la contact_list -->
                        <div class="col-md-6 div-list div-mail">
                            <!-- TODO : Prendre en compte l'utilisateur connecté pour id_user -->
                            <!-- Formulaire d'ajout de contact_list -->                            
                            <form method="post" action="manageMails.php?type=add">
                                <div class="form-group">
                                    <label>Nom du modèle : </label>
                                    <input class="form-control" type="text" name="name" placeholder="Nom du modèle" required><br>
                                    <label>Object du modèle : </label>
                                    <input class="form-control" type="text" name="object" placeholder="Object du modèle" required><br>
                                    <label>Contenu du modèle : </label>
                                    <textarea ROWS='3' COLS='40' class="form-control" type="text" name="content" placeholder="Contenu du modèle" required></textarea><br>
                                    <label>Signature du modèle : </label>
                                    <input class="form-control" type="text" name="signature" placeholder="Signature du modèle" required><br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="createModel" value="Créer">
                                </div>
                            </form>
                        </div>
                    </div>
                    <h3 class="col-md-12">Modifier un modèle</h3>
                    <div class="col-md-6 div-mail">
                        <!-- Formulaire de modification de contact-list -->
                        <?php
                            if(!empty($_GET['model_id']))
                            {
                        ?>
                        <div name="formUpdateModel" id="formUpdateModel"> 
                            <form method="post" action="manageMails.php?type=update&model_id=<?php echo $_GET['model_id']; ?>">
                                <div class="form-group" style="margin-top: -30px">
                                    <input style="visibility: hidden" class="form-control" id="id" name = "id"></input>
                                    <label>Nom du modèle : </label>
                                    <input class="form-control" type="text" name="name" placeholder="Nom du modèle" value="<?php echo $model_name; ?>" required><br>
                                    <label>Object du modèle : </label>
                                    <input class="form-control" type="text" name="object" placeholder="Object du modèle" value="<?php echo $model_object; ?>" required><br>
                                    <label>Contenu du modèle : </label>
                                    <textarea ROWS='3' COLS='40' class="form-control" type="text" name="content" placeholder="Contenu du modèle" required><?php echo $model_content; ?></textarea><br>
                                    <label>Signature du modèle : </label>
                                    <input class="form-control" type="text" name="signature" placeholder="Signature du modèle" value="<?php echo $model_signature; ?>" required><br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="UpdateModel" value="Modifier">
                                </div>
                            </form>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
</body>
</html>
