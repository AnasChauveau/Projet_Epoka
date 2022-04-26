<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Header.css" />
    <link rel="stylesheet" href="fichier.css" />
    <title>Evenement</title>
</head>
<body style="background-color: #82bdc7; background-size: cover; width: 99%;">

<?php
 include('header.php');

 if(empty($_GET["message"]) || !isset($_GET["message"])){
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Une erreur est survenue !</h1>";
 }else{
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>".$_GET["message"]."</h1>";
 }
 ?>
 </body>
 </html>