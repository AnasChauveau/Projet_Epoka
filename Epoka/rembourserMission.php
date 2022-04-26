<?php
// Récupération des identifiants 

session_start();

include('BDD.php'); // On inclut le fichier avec la chaine de connexion 
global $mysqlConnection; // Récuperation de la chaine de connection 

if (empty($_GET["id"]) || !isset($_GET["id"])) {
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=ERREUR%20:%20Mission%20introuvable%20!'); // redirection vers une page
    die();
  }

$idMission = $_GET["id"];

$sqlQuery = "UPDATE mission SET payer = 1 WHERE idMission = :idMission;";

$req = $mysqlConnection->prepare($sqlQuery); // Préparation de la requête 
$req->bindParam(':idMission', $idMission); // On remplace la valeur :idMission par la valeur récupéré en GET
$req->execute(); // On execute la requête préparé

$count = $req->rowCount();

if ($count <= 0){
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=Echec%20du%20remboursement%20!'); // redirection vers une page
}else{
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=Remboursement%20réussi%20!'); // redirection vers une page
}
?>