<?php include("header.php"); 
//session_start();
if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
?>
<head>
    <title>Rapport</title>
</head>
        <!-- Tableau de suivi des mails envoyés par la campagne -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><i class="fa fa-info-circle fa-5"></i>&nbsp;Rapport</h1>
                    </div>
                    <div class="groups-container">
                        <h3 class="col-md-6">Rapport</h3>
                        <h3 class="col-md-6" style="visibility : hidden;">a</h3>
                        <div>
                            <table class="col-md-6 table table-hover table-design">
                                <?php
                                    $sql = "SELECT *
                                            FROM tracking
                                            WHERE id_campaign=" . $_GET['campaign_id'];
                                    
                                    foreach ($dbh->query($sql) as $row)
                                    {
                                        $sql2 = "SELECT *
                                                 FROM contact
                                                 WHERE contact_id='" . $row['id_contact'] . "'";
                                        foreach ($dbh->query($sql2) as $row2) 
                                        {
                                            $contact_mail = $row2['contact_mail'];
                                        }

                                        if($row['ouvert'] == 1)
                                        {
                                            $etat = 'Ouvert';
                                            $color = 'green';
                                        }
                                        else 
                                        {
                                            $etat = 'Pas encore ouvert';
                                            $color = 'red';
                                        }

                                        echo "
                                            <tr>
                                                <td>" . $contact_mail . "</td>
                                                <td style='background-color :" . $color . "'>" . $etat . "</td>
                                            </tr>";
                                    }
                                ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>