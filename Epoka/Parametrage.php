<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Header.css" />
    <link rel="stylesheet" href="fichier.css" />
    <link rel="stylesheet" href="Index.css" />
    <title>Connexion</title>
</head>
<body>
    
<?php 
 include('header.php');
 
 include ('BDD.php');

if($_SESSION["comptable"] == 0){
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Accès refusé ! <a href='Accueil.php'> Retour</a></h1>";
}else{
    global $mysqlConnection;
    $reqResp = "SELECT * from parametre";
    $reqResp = $mysqlConnection->prepare($reqResp);
    $reqResp->execute();
    $row = $reqResp->fetchAll(PDO::FETCH_ASSOC);
 ?>


<div id="parametrage">
    <div id="box" style="margin-top: 150px;">
    <form method="post" action="updateForfait.php">
        <div style="text-align: center;"> 
            <h1 style="font-size: 19px;margin-left: 0px;">Montant du remboursement au km </h1> <br>      
        </div>
            <div>
                <label> Remboursement au km </label>
                <input type="text" name="forfaitKm" value="<?php if (!empty($row)){ echo $row[0]["forfaitKm"];}else{ echo "0";} ?>"/>
                <br><br>
            </div>
            <div>
                <label> Indemnité d'hébergement </label>
                <input type="text" name="forfaitJours" value="<?php if (!empty($row)){ echo $row[0]["forfaitJours"];}else{ echo "0";}?>"/>
                <br><br>
            </div>
            <div>
                <input class="submit" type="submit" value="Valider" />
            </div>
        </form>
    </div>

    <div id="box" style="margin-top: 5px;">
    <form method="post" action="addDistance.php">
        <div style="text-align: center;"> 
            <h1 style="font-size: 19px;margin-left: 0px;">Distance entre villes </h1>       
        </div>

            <div id="utilisateur">
                <label> Départ :</label>
                <select value="caca" style="text-align: center;" name="commune1" id="Login">
                <option value="">--Choisissez une commune de départ--</option>
                <?php
                    $reqResp = "SELECT idCommune AS ID, CONCAT(c.nomCommune, ' (' , c.cpCommune, ')') AS Commune 
                    FROM commune c limit 300";
                    $reqResp = $mysqlConnection->prepare($reqResp);
                    $reqResp->execute();
                    $row = $reqResp->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($row)){
                        foreach ($row as $item){
                            echo ('<option value="'.$item['ID'].'">'.$item['Commune'].'</option>');   
                      }
                    }
                ?>
                </select>
                <br>
                <label> Arrivée :</label>
                <select style="text-align: center;" name="commune2" id="Pwd">
                <option value="">--Choisissez une commune d'arrivée--</option>
                <?php
                    if (!empty($row)){
                        foreach ($row as $item){
                            echo ('<option value="'.$item['ID'].'">'.$item['Commune'].'</option>');   
                      }
                    }
                ?>
                </select>
                    <script>
                        function recupValeur(valeur){
                            alert(valeur);
                            console.log(valeur);
                        }
                    </script>
                <br>
                <label> Distance en km </label>
                <input type="number" name="distance" id="Pwd"/>
            </div>
            <div id="valider">
                <input class="submit" type="submit" value="Valider" />
            </div>
            <?php
            
            ?>
        </form>
    </div>

    <?php 
    $reqResp = "SELECT c1.nomCommune AS commune1, c2.nomCommune AS commune2, Distance FROM relier
    INNER JOIN commune c1 ON Id_Commune1 = c1.idCommune
    INNER JOIN commune c2 ON Id_Commune2 = c2.idCommune;";
    $reqResp = $mysqlConnection->prepare($reqResp);
    $reqResp->execute();
    $row = $reqResp->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="box" style="margin-top: 5px;">
    <form method="post" action="GetIdentifiant.php">
        <div style="text-align: center;"> 
            <h1 style="font-size: 19px;margin-left: 0px;">Distance entre villes déjà saisies </h1>       
        </div>

            <table>
            <tr>
                <th id='listeDist'>De</th>
                <th id='listeDist'>A</th>
                <th id='listeDist'>Km</th>
            </tr>
                <?php
            if (!empty($row)){
                foreach ($row as $item){
                    echo ("<tr>
                    <td id='listeDist'>".$item['commune1']."</td>
                    <td id='listeDist'>".$item['commune2']."</td>
                    <td id='listeDist'>".$item['Distance']."</td>
                </tr>");   
              }
            }else{
            echo "<h3>Aucune distance trouvé !</h3>";
            }
    ?>
            </table>
        </form>
    </div>
</div>
</body>
<?php } ?>