<?php include("header.php"); 
//session_start();

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
?>
<head>
    <script language="Javascript">
        function popFormList(listId)
        {
                if(document.getElementById('formUpdateList').style.visibility="hidden")
                {
                    var name = document.getElementById('row-list-'+listId).innerHTML;
                    console.log(name, listId);
                    $('#input_update_list').val(name);
                    $('#input_update_list2').val(listId);
                    document.getElementById('formUpdateList').style.visibility="visible";
                    document.getElementById('formUpdateContact').style.visibility="hidden";
                }
        }
        
        function popFormContact(contactId)
        {
                if(document.getElementById('formUpdateContact').style.visibility="hidden")
                {
                    var name = document.getElementById('td-contact-name-'+contactId).innerHTML;
                    var mail = document.getElementById('td-contact-mail-'+contactId).innerHTML;
                    console.log(name, mail, contactId);
                    $('#input_update_contact1').val(name);
                    $('#input_update_contact3').val(mail);
                    $('#input_update_contact2').val(contactId);
                    document.getElementById('formUpdateContact').style.visibility="visible";
                    document.getElementById('formUpdateList').style.visibility="hidden";
                }
        }
        function popFormContactOther(contactId)
        {
                if(document.getElementById('formUpdateContact').style.visibility="hidden")
                {
                    var name = document.getElementById('td-contact2-name-'+contactId).innerHTML;
                    var mail = document.getElementById('td-contact2-mail-'+contactId).innerHTML;
                    console.log(name, mail, contactId);
                    $('#input_update_contact1').val(name);
                    $('#input_update_contact3').val(mail);
                    $('#input_update_contact2').val(contactId);
                    document.getElementById('formUpdateContact').style.visibility="visible";
                    document.getElementById('formUpdateList').style.visibility="hidden";
                }
        }
        function confirmDelete(listId)
        {
            if (confirm("Vous êtes sur le point de supprimer un groupe. Continuer ?") == true) 
            {
                document.location.href="manageGroups.php?type=delete&list_id=" + listId;
            }
        }
    </script> 
    <?php
    if(!empty($_GET['id']))
    {
        $sql = "SELECT list_name FROM contact_list WHERE list_id=" . $_GET['id'];
        foreach ($dbh->query($sql) as $row)
        {
            $groups_name = $row['list_name'];
        }
    }
    ?>
    <title>Mes groupes</title>
</head>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><i class="fa fa-users fa-5"></i>&nbsp;Groupes de contacts</h1>
                    </div>
                    <div class="groups-container">
                        <h3 class="col-md-6">Mes groupes</h3>
                        <h3 class="col-md-6">Mes contacts du groupe :&nbsp<strong><?php if(!empty($_GET['id'])) echo $groups_name; ?></strong></h3>
                        <!--Affichage de la liste des contact_list -->
                        <div class="col-md-6 div-contact">
                            <table class="col-md-12 table table-hover table-design">
                                <?php 
                                    $sql = "SELECT list_name, list_id 
                                            FROM contact_list 
                                            WHERE id_user=" . $_SESSION['user'];
                                    foreach ($dbh->query($sql) as $row)
                                    {
                                        echo "
                                            <tr>
                                                <td style='visibility: hidden; position:absolute'>" . $row["list_id"] . "</td>
                                                <td>
                                                    <i class='fa fa-users fa-2'></i>
                                                </td>
                                                <td>
                                                    <label id='row-list-" . $row['list_id'] . "'>" . $row['list_name'] . "</label>
                                                </td>
                                                <td>
                                                    <a style='color: black;cursor: pointer' title='Editer' href='?id=".$row['list_id']."'>
                                                        <i class='fa fa-user-plus fa-2'></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a style='color: black;cursor: pointer' title='Modifier' onclick='popFormList(" . $row['list_id'] . ")'>
                                                        <i class='fa fa-cog fa-2'></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a style='color: black;cursor: pointer' title='Supprimer' onclick='confirmDelete(\"" . $row["list_id"] . "\")'>
                                                        <i class='fa fa-trash-o fa-2'></i>
                                                    </a>
                                                </td>
                                            </tr>";
                                    }
                                ?>
                            </table>
                        </div>
                        <!--Affichage de la liste des contact de la contact_list -->
                        <div class="col-md-6 div-contact">
                            <table class="col-md-12 table table-hover table-design">
                            <?php 
                            if(!empty($_GET['id']))
                            {
                                $sql = "SELECT contact_name, contact_mail, contact_id 
                                        FROM contact, appartient, contact_list 
                                        WHERE appartient.id_contact_list = contact_list.list_id 
                                        AND contact.contact_id = appartient.id_contact 
                                        AND contact_list.list_id =". $_GET['id'] . " 
                                        AND contact.id_user=" . $_SESSION['user'] ." 
                                        AND contact_list.id_user=" . $_SESSION['user'];
                                foreach ($dbh->query($sql) as $row)
                                {
                                    echo "
                                        <tr>
                                            <td style='visibility: hidden; position:absolute'id='td-contact-id-" . $row['contact_id'] . "'>" . $row['contact_id'] . "</td>
                                            <td>
                                                    <i class='fa fa-user fa-2'></i>
                                            </td>
                                            <td id='td-contact-name-" . $row['contact_id'] . "'>" . $row["contact_name"] ." </td>
                                            <td id='td-contact-mail-" . $row['contact_id'] . "'> ". $row["contact_mail"] ."</td>
                                            <td>
                                                <a style='color: black;cursor: pointer' title='modifier' onclick='popFormContact(\"" . $row['contact_id'] . "\")'>
                                                    <i class='fa fa-cog fa-2'></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a style='color: red' title='Supprimer' href='manageGroups.php?type=deleteUser&id=". $row['contact_id'] ."&id_list=" . $_GET['id'] ."'>
                                                    <i class='fa fa-minus fa-2'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                }
                            }
                            ?>
                            </table>
                        </div>
                    </div>
                    <div>
                        <h3 class="col-md-6">Créer un groupe</h3>
                        <h3 class="col-md-6">Mes contacts</h3>
                        <div class="col-md-6 div-list div-ajout">
                            <!-- TODO : Prendre en compte l'utilisateur connecté pour id_user -->
                            <!-- Formulaire d'ajout de contact_list -->                            
                            <form method="post" action="manageGroups.php?type=add">
                                <div class="form-group">
                                    <label>Nom du groupe : </label>
                                    <input class="form-control" type="text" name="name" placeholder="Nom du groupe" required><br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="createGroup" value="Créer">
                                </div>
                            </form>
                        </div>
                        <div class='col-md-6 div-other-contact'>
                        <!--Affichage de la liste des contact pour ajout dans une contact_list -->                            
                            <table class="col-md-12 table table-hover table-design">
                            <?php 
                            if(!empty($_GET['id']))
                            {
                                $sql = "SELECT distinct (contact.contact_name), contact.contact_id, contact.contact_mail 
                                FROM contact 
                                WHERE contact_name not in (SELECT contact_name FROM contact, appartient, contact_list 
                                                            WHERE appartient.id_contact_list = contact_list.list_id 
                                                            AND contact.contact_id = appartient.id_contact 
                                                            AND contact_list.list_id ='" . $_GET['id'] . "')";
                                foreach ($dbh->query($sql) as $row)
                                {
                                    echo "
                                        <tr>
                                            <td style='visibility: hidden; position:absolute' id='td-contact2-id-" . $row['contact_id'] . "'>" . $row['contact_id'] . "</td>
                                            <td>
                                                    <i class='fa fa-user fa-2'></i>
                                            </td>
                                            <td id='td-contact2-name-" . $row['contact_id'] . "'>" . $row["contact_name"] ." </td>
                                            <td id='td-contact2-mail-" . $row['contact_id'] . "'> ". $row["contact_mail"] ."</td>
                                            <td>
                                                <a style='color: black;cursor: pointer' title='modifier' onclick='popFormContactOther(\"" . $row['contact_id'] . "\")'>
                                                    <i class='fa fa-cog fa-2'></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a style='color: green' title='Ajouter' href='manageGroups.php?type=addUser&id=". $row['contact_id'] ."&id_list=" . $_GET['id'] ."'>
                                                    <i class='fa fa-plus fa-2'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                }
                            }
                            ?>
                            </table>
                        </div>
                    </div>
                    <h3 class="col-md-12">Modifier un groupe</h3>
                    <div class="col-md-6 div-update">
                        <!-- Formulaire de modification de contact-list -->
                        <div class="col-md-12" name="formUpdateList" id="formUpdateList" style="visibility: hidden"> 
                            <form method="post" action="manageGroups.php?type=updateList"> 
                                <div class="form-group">
                                    <input style="visibility: hidden" class="form-control" name ="input_id_list" id="input_update_list2"></input>
                                    <label>Nom du groupe : </label>
                                    <input class="form-control" id="input_update_list" type="text" name="name" placeholder="Nom du groupe" required><br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="updateGroup" value="Modifier">
                                </div>
                            </form>
                        </div>
                        <!-- Formulaire de modification de contact -->
                        <div name="formUpdateContact" id="formUpdateContact" style="visibility: hidden"> 
                            <form method="post" action="manageGroups.php?type=updateContact"> 
                                <div class="form-group">
                                    <input style="visibility: hidden" class="form-control" id="input_update_contact2" name = "id"></input>
                                    <label>Nom du contact : </label>
                                    <input class="form-control" id="input_update_contact1" type="text" name="name_contact" placeholder="Nom du groupe" required><br>
                                    <label>Email du contact : </label>
                                    <input class="form-control" id="input_update_contact3" type="text" name="mail_contact" placeholder="Email du contact" required><br>
                                    <input class="btn btn-default btn-lg btn-block" type="submit" name="updateContact" value="Modifier">
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