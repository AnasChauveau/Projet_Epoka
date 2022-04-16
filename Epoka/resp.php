<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Header.css" />
    <link rel="stylesheet" href="fichier.css" />
    <link rel="stylesheet" href="~/lib/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="~/css/site.css" />
    <title>Responsable</title>
</head>
<body style="background-color: #82bdc7; background-size: cover; width: 99%;">

<?php
 include('header.php');

 include ('BDD.php');

$identifiant = $_SESSION["identifiant"];



global $mysqlConnection;
$reqResp = "SELECT COUNT(*) As nb
FROM mission m
INNER JOIN salarie s ON s.identifiant = m.identifiantSal
WHERE identifiantResp = :idResp";
$reqResp = $mysqlConnection->prepare($reqResp);
$reqResp->bindParam(':idResp', $identifiant);
$reqResp->execute();
$row = $reqResp->fetchAll(PDO::FETCH_ASSOC);

if (empty($row)){
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Une erreur est survenu ! <a href='/Epoka/Accueil.php'> Retour</a></h1>";
}else if($row[0]["nb"] == 0){
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Accès refusé ! <a href='/Epoka/Accueil.php'> Retour</a></h1>";
}else{
?>
    <h1 style="margin-top: 150px; color: white;  margin-left: 3%;">Validation des missions de vos salariés</h1>
    <table style='width: 85%;'>
        <tr>
            <th style=' text-align: center;'>nom</th>
            <th style=' text-align: center;'>prenom</th>
            <th style=' text-align: center;'>debut</th>
            <th style=' text-align: center;'>fin</th>
            <th style=' text-align: center;'>lieu</th>
            <th style=' text-align: center;'>Validation</th>
        </tr>
    <?php

        $reqMission = "SELECT m.idMission,
                            prenomSal AS Prenom,
                            nomSal AS Nom,
                            dateDebut as Debut, 
                            dateFin AS Fin, 
                            valider,
                            payer,
                            CONCAT(c.nomCommune, '(', c.cpCommune, ')') AS Lieu,
                            CASE 
                                WHEN valider = 0 THEN ''
                                WHEN valider = 1 AND payer = 1 THEN CONCAT('Validée, ', 'Remboursée')
                                WHEN valider = 1 THEN 'Validée'
                            END AS validation 
                        FROM mission m
                        INNER JOIN salarie s ON s.identifiant = m.identifiantSal
                        INNER JOIN commune c ON c.idCommune = m.Id_Commune
                        WHERE identifiantResp = :idResp
                        AND dateFin BETWEEN SUBDATE(CURDATE(), 30) AND CURDATE()
                        ORDER by validation, Fin;";
        $reqMission = $mysqlConnection->prepare($reqMission);
        $reqMission->bindParam(':idResp', $identifiant);
        $reqMission->execute();
        $row = $reqMission->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($row)){
            foreach ($row as $item){
                echo("<tr>
                <td style=' text-align: center;'>".$item['Nom']."</td>
                <td style=' text-align: center;'>".$item['Prenom']."</td>
                <td style=' text-align: center;'>".$item['Debut']."</td>
                <td style=' text-align: center;'>".$item['Fin']."</td>
                <td style=' text-align: center;'>".$item['Lieu']."</td>
                <td style=' text-align: center;'>");
                if (!empty($item['validation'])) {echo ($item['validation']); }else{ echo ("<a href=''>Valider</a>"); }
                echo("</td></tr>");
            }
        }else{
            echo "<h1 style='margin-top: 150px; color: white;  margin-left: 3%;'>Une erreur est survenu ! <a href='/Epoka/Accueil.php'> Retour</a></h1>";
        }  
    }

?>
    </table>
</body>
</html>