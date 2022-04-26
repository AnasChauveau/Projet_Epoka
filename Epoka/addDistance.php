<?php
// Récupération des identifiants 

session_start();

include('BDD.php'); // On inclut le fichier avec la chaine de connexion 
global $mysqlConnection; // Récuperation de la chaine de connection 

if (empty($_POST["commune1"]) || !isset($_POST["commune1"]) || empty($_POST["commune2"]) || !isset($_POST["commune2"]) || empty($_POST["distance"]) || !isset($_POST["distance"])) {
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=ERREUR%20:%20Mission%20introuvable%20!'); // redirection vers une page
    die();
  }

$commune1 = $_POST["commune1"];
$commune2 = $_POST["commune2"];
$distance = $_POST["distance"];

$sqlQuery = "INSERT INTO relier (Id_Commune1, Id_Commune2, Distance) VALUES (:commune1, :commune2, :distance)";

$req = $mysqlConnection->prepare($sqlQuery); // Préparation de la requête 
$req->bindParam(':commune1', $commune1); 
$req->bindParam(':commune2', $commune2); 
$req->bindParam(':distance', $distance); 
$req->execute(); // On execute la requête préparé

$count = $req->rowCount();

if ($count <= 0){
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=Echec%20de%20l\'Ajout%20!'); // redirection vers une page
}else{
    header('Location: /Projet_Epoka/Epoka/evenement.php?message=Ajout%20réussi%20!'); // redirection vers une page
}
?>