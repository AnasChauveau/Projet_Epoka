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
<?php include('header.php');
    if (!empty($_SESSION["identifiant"]) && isset($_SESSION["identifiant"])) {
        echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Vous êtes Connecté !</h1>";
    }
?>

</body>

