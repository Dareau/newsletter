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
    //Recupération des informations du model focus
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
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="cross-browser rich text editor, rte, textarea, htmlarea, content management, cms, blog, internet explorer, firefox, safari, opera, netscape, konqueror" />
	<meta name="description" content="The cross-browser rich-text editor (RTE) is based on the designMode() functionality introduced in Internet Explorer 5, and implemented in Mozilla 1.3+ using the Mozilla Rich Text Editing API." />
	<meta name="author" content="Kevin Roth" />
	<meta name="ROBOTS" content="ALL" />
	<!-- html2xhtml.js written by Jacob Lee <letsgolee@lycos.co.kr> //-->
	<script language="JavaScript" type="text/javascript" src="cbrte/html2xhtml.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="cbrte/richtext.min.js"></script>
    <script>
        function confirmDelete(modelId)
        {
            //Script de la confirmation de suppression
            if (confirm("Vous êtes sur le point de supprimer un modèle. Continuer ? \n (ATTENTION : Toutes campagnes utilisants ce model sera supprimées)") == true) 
            {
                document.location.href="manageMails.php?type=delete&model_id=" + modelId;
            }
        }
    </script>
    <title>Mes Mails</title>
</head>
<?php
    //GESTION DES MESSAGES D'ERREUR OU DE SUCCES
    if(!empty($_GET['error']))
    {
        if($_GET['error'] == 'true')
        {
            echo '<div class="alert alert-danger" role="alert">Erreur : Modèle déjà existant </div>';
        }
        elseif ($_GET['error'] == 'false') 
        {
            echo '<div class="alert alert-success" role="alert">Succès : Opération réussie</div>';
        }
    }
?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><i class="fa fa-envelope fa-5"></i>&nbsp;Mails</h1>
                    </div>
                    <div class="groups-container">
                        <h3 class="col-md-6">Mes modèles</h3>
                        <h3 class="col-md-6" style="visibility : hidden">a</h3>
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
                        <div id="custom-rte-div">
                            <!-- Formulaire d'ajout de Model -->
                            <h3>Ajouter un modèle</h3>                         
                            <form name="RTEDemo" action="manageMails.php?type=add" method="post" onsubmit="return submitForm();">
                                <input class="col-md-2" type="text" name="name" placeholder="Nom" required>
                                <input type="text" name="object" placeholder="Object" required>
                                <script language="JavaScript" type="text/javascript">
                                    function submitForm() {
                                        //make sure hidden and iframe values are in sync for all rtes before submitting form
                                        updateRTEs();
                                        
                                        return true;
                                    }
                                    //Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML, encHTML)
                                    initRTE("cbrte/images/", "cbrte/", "", true);
                                </script>
                                <noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>

                                <script language="JavaScript" type="text/javascript">
                                //build new richTextEditor
                                var rte1 = new richTextEditor('rte1');
                                <?php
                                //format content for preloading
                                if (!(isset($_POST["rte1"]))) {
                                    $content = "Build your newsletter here.";
                                    $content = rteSafe($content);
                                } else {
                                    //retrieve posted value
                                    $content = rteSafe($_POST["rte1"]);
                                }
                                ?>
                                rte1.cmdJustifyLeft = false;
                                rte1.cmdJustifyCenter = false;
                                rte1.cmdJustifyRight = false;
                                rte1.cmdJustifyFull = false;
                                rte1.cmdHiliteColor = false;
                                rte1.height = 250;
                                rte1.width = 850;
                                rte1.html = '<?=$content;?>';

                                //rte1.toggleSrc = false;
                                rte1.build();
                                </script>
                                <input class="col-md-2" type="text" name="signature" placeholder="Signature" required>
                                <p><input type="submit" name="createModel" value="Submit" /></p>
                            </form>
                            </div>
                    </div>
                    <h3 class="col-md-12">Modifier un modèle</h3>
                    <div class="col-md-6">
                        <!-- Formulaire de modification de Model -->
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
    </div>
    <?php
        function rteSafe($strText) {
            //returns safe code for preloading in the RTE
            $tmpString = $strText;
            
            //convert all types of single quotes
            $tmpString = str_replace(chr(145), chr(39), $tmpString);
            $tmpString = str_replace(chr(146), chr(39), $tmpString);
            $tmpString = str_replace("'", "&#39;", $tmpString);
            
            //convert all types of double quotes
            $tmpString = str_replace(chr(147), chr(34), $tmpString);
            $tmpString = str_replace(chr(148), chr(34), $tmpString);
            //$tmpString = str_replace("\"", "\"", $tmpString);
            
            //replace carriage returns & line feeds
            $tmpString = str_replace(chr(10), " ", $tmpString);
            $tmpString = str_replace(chr(13), " ", $tmpString);
            
            return $tmpString;
        }
    ?>
</body>
</html>
