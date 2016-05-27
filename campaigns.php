<?php include("header.php"); 
//session_start();

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
?>
<?php
    if(!empty($_GET['id']))
    {
        $sql = "SELECT * 
                FROM campaign, contact_list, model 
                WHERE campaign.id_model = model.model_id 
                AND contact_list.list_id = campaign.id_contact_list 
                AND campaign_id=" . $_GET['id'];
       
        foreach ($dbh->query($sql) as $row)
        {
            $campaign_name = $row['campaign_name'];
            $campaign_id = $row['campaign_id'];
            $model_name = $row['model_name'];
            $model_id = $row['model_id'];
            $list_name = $row['list_name'];
            $list_id = $row['list_id'];
        }
    }
    ?>
<head>
    <script language="Javascript">
        function popFormCampaign(campaignId, listId, modelId)
        {
            var campaign_name = document.getElementById('td-campaign-name-'+ campaignId).innerHTML;
            var model_name = document.getElementById('td-model-name-'+ campaignId).innerHTML;
            var list_name = document.getElementById('td-list-name-'+ campaignId).innerHTML;
            console.log(campaignId, listId, modelId, campaign_name, model_name, list_name);
            
            $('#input_id_campaign').val(campaignId);
            $('#input_campaign_name').val(campaign_name);
            $('#select_model_name-' + modelId).attr('selected','selected');
            $('#select_list_name-' + listId).attr('selected','selected');
            
            document.getElementById('formUpdateCampaign').style.visibility="visible";
        }
        function confirmDelete(campaignId)
        {
            if (confirm("Vous êtes sur le point de supprimer une campagne. Continuer ?") == true) 
            {
                document.location.href="manageCampaigns.php?type=delete&campaign_id=" + campaignId;
            }
        }
    </script>
    <title>Mes campagnes</title>
</head>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><i class="fa fa-flag fa-5"></i>&nbsp;Campagnes</h1>                     
                    </div>
                    <div clas="groups-container">
                        <h3 class="col-md-6">Mes campagnes</h3>
                        <h3 class="col-md-6">Ma campagne :&nbsp<strong><?php if(!empty($_GET['id'])) echo $campaign_name; ?></strong> </h3>
                        <!--Affichage de la liste des contact_list -->
                        <div class="col-md-6 div-contact">
                            <table class="col-md-12 table table-hover table-design">
                                <?php 
                                    $sql = "SELECT * 
                                            FROM campaign, contact_list, model 
                                            WHERE campaign.id_model = model.model_id 
                                            AND contact_list.list_id = campaign.id_contact_list 
                                            AND campaign.id_user=" . $_SESSION['user'];
                                    
                                    
                                    foreach ($dbh->query($sql) as $row)
                                    {
                                        echo "
                                            <tr>
                                                <td style='visibility: hidden; position:absolute'>" . $row["list_id"] . "</td>
                                                <td>
                                                    <i class='fa fa-flag fa-2'></i>
                                                </td>
                                                <td>
                                                    <label id='td-campaign-name-" . $row['campaign_id'] . "'>" . $row['campaign_name'] . "</label>
                                                </td>
                                                <td>
                                                    <label id='td-model-name-" . $row['campaign_id'] . "'>" . $row['model_name'] . "</label>
                                                </td>
                                                <td>
                                                    <label id='td-list-name-" . $row['campaign_id'] . "'>" . $row['list_name'] . "</label>
                                                </td>
                                                <td>
                                                    <a style='color: black;cursor: pointer' title='Gérer' href='?id=".$row['campaign_id']."'>
                                                        <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                                                    </a>
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </table>
                        </div>
                        <div class="col-md-6 div-contact">
                            <?php if(!empty($_GET['id'])) { ?>
                            <form method="post" action="manageCampaigns.php?type=send&id_model=<?php echo $model_id; ?>">
                                <table>
                                    <tr>
                                        <td><i class="fa fa-flag fa-2"></i></td>
                                        <td><label>Campagne</label></td>
                                        <td><label name="campaign_name"><?php echo $campaign_name ; ?></label></td>
                                        <td>
                                            <?php
                                                echo "
                                                    <a style='color: black;cursor: pointer' title='Modifier' onclick='popFormCampaign(\"" . $campaign_id. "\",\"" . $list_id . "\",\"" . $model_id . "\")'>
                                                        <i class='fa fa-cog fa-2'></i>
                                                    </a>
                                                ";
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                echo "
                                                    <a style='color: black;cursor: pointer' title='Supprimer' onclick='confirmDelete(\"" . $campaign_id . "\")'>
                                                        <i class='fa fa-trash-o fa-2'></i>
                                                    </a>
                                                ";
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-envelope fa-2"></i></td>
                                        <td><label>Model</label></td>
                                        <td colspan="3"><a name="model_name" href="mails.php"><?php echo $model_name ; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td><i class='fa fa-users fa-2'></i></td>
                                        <td><label>Liste de contactes</label></td>
                                        <td colspan="3"><a name="list_id" href='groups.php?id="<?php echo $list_id ;?>"'><?php echo $list_name ; ?></a></td>
                                        <input type="hidden" name="list_id" value="<?php echo $list_id; ?>" />
                                    </tr>
                                    <tr>
                                        <td colspan="5"><input class="btn btn-default btn-lg btn-block" type="submit" name="sendCampaign" value="Envoyer"></td>
                                    </tr>
                                </table>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <div>
                        <h3 class="col-md-6">Créer une campagne</h3>
                        <h3 class="col-md-6">Modifier une campagne</h3>
                        <div class="col-md-6 div-list div-extend">
                            <form method="post" action="manageCampaigns.php?type=add">
                                <?php 
                                    $sql_list = "SELECT list_name, list_id 
                                            FROM contact_list 
                                            WHERE id_user=" . $_SESSION['user'];
                                    $sql_model = "SELECT model_name, model_id 
                                            FROM model 
                                            WHERE user_id=" . $_SESSION['user'];
                                ?>
                                <div class="form-group">
                                    <label>Nom de la campagne : </label>
                                    <input class="form-control" type="text" name="name" placeholder="Nom de la campagne" required><br>
                                    <label>Model : </label>
                                    <select id="select_model" name="select_model" class="form-control">
                                        <option disabled selected>Selectionnez un model</option>
                                        <?php 
                                            foreach ($dbh->query($sql_model) as $row)
                                            {
                                                echo "<option value=".$row['model_id'].">".$row['model_name']."</option>";
                                            }
                                        ?>
                                    </select></br>
                                    <label>Groupe : </label>
                                    <select id="select_list" name="select_list" class="form-control">
                                        <option disabled selected>Selectionnez un groupe</option>
                                        <?php 
                                            foreach ($dbh->query($sql_list) as $row)
                                            {
                                                echo "<option value=".$row['list_id'].">".$row['list_name']."</option>";
                                            }
                                        ?>
                                    </select></br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="createCampaign" value="Créer">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 div-list div-extend">
                            <form method="post" action="manageCampaigns.php?type=update">
                                <div class="form-group" id="formUpdateCampaign" style="visibility: hidden; margin-top: -30px">
                                    <input style="visibility: hidden" class="form-control" id="input_id_campaign" name = "id"></input>
                                    <label>Nom de la campagne : </label>
                                    <input class="form-control" id="input_campaign_name" type="text" name="name" placeholder="Nom de la campagne" required><br>
                                    <label>Nom du modèle : </label>
                                    <select id="select_model" name="select_model" class="form-control">
                                        <option disabled selected>Selectionnez un model</option>
                                        <?php 
                                            foreach ($dbh->query($sql_model) as $row)
                                            {
                                                echo "<option id='select_model_name-" . $row['model_id']. "' value=".$row['model_id'].">".$row['model_name']."</option>";
                                            }
                                        ?>
                                    </select></br>
                                    <label>Groupe : </label>
                                    <select id="select_list" name="select_list" class="form-control">
                                        <option disabled selected>Selectionnez un groupe</option>
                                        <?php 
                                            foreach ($dbh->query($sql_list) as $row)
                                            {
                                                echo "<option id='select_list_name-" . $row['list_id'] . "' value=".$row['list_id'].">".$row['list_name']."</option>";
                                            }
                                        ?>
                                    </select></br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="updateCampaign" value="Modifier">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>
</html>
