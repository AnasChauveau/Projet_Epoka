<?php 

try{ //Bloc qui permet de capturer l'erreur 

// Chaîne de connexion pour la BDD
$mysqlConnection = new PDO(
    'mysql:dbname=zaraco-layenne_epoka;host=mysql-zaraco-layenne.alwaysdata.net;charset=utf8;', //Information pour la connexion à always data
    '251749_valanas', // Le nom d'utilisateur du compte
    'Valanas38' // Le mot de passe de celui ci
);

}catch (Exception $e){

        die('Erreur : ' . $e->getMessage()); // Met fin au script si une erreur est déclarée
}

?>