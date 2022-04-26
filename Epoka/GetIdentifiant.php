<?php
// Récupération des identifiants 

session_start();

include('BDD.php'); // On inclut le fichier avec la chaine de connexion 
global $mysqlConnection; // Récuperation de la chaine de connection 

$login = $_POST['Login']; // Recuperation de login
$password = $_POST['Pwd']; // Recuperation de password

  if (empty($login) || !isset($login)) {
    header('Location: /Projet_Epoka/Epoka?message=Le%20login%20manque'); // redirection vers une page
    die();
  } 
  
  if (empty($password) || !isset($password)) {
    header('Location: /Projet_Epoka/Epoka?message=Le%20mot%20de%20passe%20manque'); // redirection vers une page
    die();
  }

// Requête SQL pour la récupération des information de la personne
$sqlQuery = "SELECT Count(*) as Nombre,
                    identifiant, 
                    nomSal,
                    prenomSal, 
                    comptable
             FROM salarie
             WHERE mdp = :mdp
             AND identifiant = :identifiant;
             GROUP BY identifiant";

$req = $mysqlConnection->prepare($sqlQuery); // Préparation de la requête 
$req->bindParam(':mdp', $password); // On remplace la valeur :mdp par la valeur récupéré en POST
$req->bindParam(':identifiant', $login); // On remplace la valeur :identifiant par la valeur récupéré en POST
$req->execute(); // On execute la requête préparé

$num_rows = $req->fetchAll(PDO::FETCH_ASSOC);

if ($num_rows[0]['Nombre'] <= 0){
  header('Location: /Projet_Epoka/Epoka?message=Aucun%20compte%20trouve'); // redirection vers une page
} else if ($num_rows[0]['Nombre'] > 1) {
  header('Location: /Projet_Epoka/Epoka?message=Plusieurs%20compte%20cree'); // redirection vers une page
} else {
  $result = $req->fetchAll(PDO::FETCH_ASSOC);

  $_SESSION["identifiant"] =$num_rows[0]['identifiant'];
  $_SESSION["nom"] = $num_rows[0]['nomSal'];
  $_SESSION["prenom"] = $num_rows[0]['prenomSal'];
  $_SESSION["comptable"] = $num_rows[0]['comptable'];
  header('Location: Accueil.php'); // redirection vers une page
}

$result = $req->fetchAll(PDO::FETCH_ASSOC);

?>