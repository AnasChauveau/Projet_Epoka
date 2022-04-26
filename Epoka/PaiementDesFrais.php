<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Header.css" />
    <link rel="stylesheet" href="fichier.css" />
    <title>Connexion</title>
</head>

<body style="background-color: #82bdc7; background-size: cover; width: 99%;">

<?php 
 include('header.php');

 include ('BDD.php');

if($_SESSION["comptable"] == 0){
    echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Accès refusé ! <a href='Accueil.php'> Retour</a></h1>";
}else{
    $identifiant = $_SESSION["identifiant"];
    $comptable = $_SESSION["comptable"];
?>
    <h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Validation des missions de vos salariés</h1>
        <table style='width: 90%; margin-left: 3%'>
            <tr>
                <th id='tableMission'>Nom du salarié</th>
                <th id='tableMission'>Prénom du salarié</th>
                <th id='tableMission'>Début de la mission</th>
                <th id='tableMission'>Fin de la mission</th>
                <th id='tableMission'>Lieu de la mission</th>
                <th id='tableMission'>Montant</th>
                <th id='tableMission'>Paiement</th>
            </tr>

    <?php 
    global $mysqlConnection;
    $reqResp = "SELECT DISTINCT m.idMission,
                    prenomSal AS Prenom,
                    nomSal AS Nom,
                    dateDebut as Debut, 
                    dateFin AS Fin, 
                    payer,
                    CONCAT(cm.nomCommune, '(', cm.cpCommune, ')') AS Lieu,
                    CASE
                        WHEN isnull(Distance) = 1 THEN CONCAT(DATEDIFF(dateFin, dateDebut)*forfaitJours, '.00 $')
                        WHEN isnull(Distance) = 0 THEN CONCAT(((Distance*2)*forfaitKm)+(DATEDIFF(dateFin, dateDebut)*forfaitJours), '.00 $')
                    END AS Montant,
                    CASE 
                        WHEN isnull(Distance) = 1 AND payer = 0 THEN CONCAT('Distance entre ', ca.nomCommune, ' et ', cm.nomCommune, ' non defini') 
                        WHEN payer = 0 THEN ''
                        WHEN payer = 1 THEN 'Remboursée'
                    END AS remboursement
                FROM salarie s
                INNER JOIN mission m ON m.identifiantSal = s.Identifiant
                INNER JOIN parametre
                INNER JOIN agence a ON a.idAgence = s.Id_Agence
                INNER JOIN commune cm ON cm.idCommune = m.Id_Commune
                INNER JOIN commune ca ON ca.idCommune = a.Id_Commune
                LEFT JOIN relier r ON r.Id_Commune1 = cm.idCommune AND r.Id_Commune2 = ca.idCommune
                WHERE m.valider = '1'
                order by remboursement, Fin, Nom, Prenom;";
    $reqResp = $mysqlConnection->prepare($reqResp);
    $reqResp->execute();
    $row = $reqResp->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($row)){
        foreach ($row as $item){
            echo("<tr>
                <td id='tableMission'>".$item['Nom']."</td>
                <td id='tableMission'>".$item['Prenom']."</td>
                <td id='tableMission'>".$item['Debut']."</td>
                <td id='tableMission'>".$item['Fin']."</td>
                <td id='tableMission'>".$item['Lieu']."</td>
                <td id='tableMission'>".$item['Montant']."</td>
                <td id='tableMission'>");
                if (!empty($item['remboursement'])) {echo ($item['remboursement']); }else{ echo ("<a href='rembourserMission.php?id=".$item['idMission']."'>Rembourser</a>"); }
                echo("</td></tr>");
        }
    }else{
        echo "<h1 style='margin-top: 150px; color: white; margin-left: 3%;'>Une erreur est survenu ! <a href='Accueil.php'> Retour</a></h1>";
    } 
}


?>

</body>
</html>