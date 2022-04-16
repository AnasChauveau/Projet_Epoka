<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Header.css" />
    <link rel="stylesheet" href="fichier.css" />
    <link rel="stylesheet" href="Index.css" />
    <link rel="stylesheet" href="~/lib/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="~/css/site.css" />
    <title>Connexion</title>
</head>
<body>
    
<?php 
 include('header.php');
 
 include ('BDD.php');

if($_SESSION["comptable"] == 0){
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Accès refusé ! <a href='/Epoka/Accueil.php'> Retour</a></h1>";
}else{
 ?>


<div id="parametrage">
    <div id="box" style="margin-top: 130px;">
    <form method="post" action="/Epoka/GetIdentifiant.php">
        <div style="text-align: center;"> 
            <h1 style="font-size: 19px;margin-left: 0px;">Montant du remboursement au km </h1> <br>      
        </div>
            <div>
                <label> Remboursement au km </label>
                <input type="text" name="Login" id="Login"/>
                <br><br>
            </div>
            <div>
                <label> Indemnité d'hébergement </label>
                <input type="text" name="Pwd" id="Pwd"/>
                <br><br>
            </div>
            <div>
                <input class="submit" type="submit" value="Valider" />
            </div>
        </form>
    </div>

    <div id="box" style="margin-top: 5px;">
    <form method="post" action="/Epoka/GetIdentifiant.php">
        <div style="text-align: center;"> 
            <h1 style="font-size: 19px;margin-left: 0px;">Distance entre villes </h1>       
        </div>

            <div id="utilisateur">
                <label> De </label>
                <select name="Login" id="Login">
                    <option value="">--Choississez une commune de départ--</option>
                    <option value="Grenoble">Grenoble</option>
                </select>
                <label> à </label>
                <select name="Pwd" id="Pwd">
                    <option value="">--Choississez une commune d'arriver--</option>
                    <option value="Versaille">Versaille</option>
                </select>
                <label> distance en km </label>
                <input type="text" name="Pwd" id="Pwd"/>
            </div>
            <div id="valider">
                <input class="submit" type="submit" value="Valider" />
            </div>
            <?php
            
            ?>
        </form>
    </div>

    <div id="box" style="margin-top: 5px;">
    <form method="post" action="/Epoka/GetIdentifiant.php">
        <div style="text-align: center;"> 
            <h1 style="font-size: 19px;margin-left: 0px;">Distance entre villes déjà saisies </h1>       
        </div>

            <table>
            <tr>
                <th>De</th>
                <th>A</th>
                <th>Km</th>
            </tr>

            <?php ?>

            <tr>
                <td>Grenoble</td>
                <td>Chambery</td>
                <td>40</td>
            </tr>
            </table>
        </form>
    </div>
</div>
</body>
<?php } ?>