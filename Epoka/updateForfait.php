<?php
// Récupération des identifiants 

session_start();

include('BDD.php'); // On inclut le fichier avec la chaine de connexion 
global $mysqlConnection; // Récuperation de la chaine de connection 

if (empty($_POST["forfaitKm"]) || !isset($_POST["forfaitKm"]) || empty($_POST["forfaitJours"]) || !isset($_POST["forfaitJours"])) {
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=ERREUR%20:%20Paramètres%20introuvable%20!'); // redirection vers une page
    die();
  }

$forfaitKm = $_POST["forfaitKm"];
$forfaitJours = $_POST["forfaitJours"];

$sqlQuery = "UPDATE parametre SET forfaitKm = :forfaitKm, forfaitJours = :forfaitJours";

$req = $mysqlConnection->prepare($sqlQuery); // Préparation de la requête 
$req->bindParam(':forfaitKm', $forfaitKm); 
$req->bindParam(':forfaitJours', $forfaitJours); 
$req->execute(); // On execute la requête préparé

$count = $req->rowCount();

if ($count <= 0){
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=Echec%20de%20la%20modification%20!'); // redirection vers une page
}else{
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=Modification%20réussi%20!'); // redirection vers une page
}
?>