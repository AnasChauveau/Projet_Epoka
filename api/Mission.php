<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
			if (isset($_GET["identifiant"])){
				$identifiant = $_GET["identifiant"];
				getProducts($identifiant);			
			}else{				
				getCompta();			
			}
	
		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
	}

    function getProducts($identifiant)	
	{
		global $conn;
		$dateToday = date_create(date("Y-m-d"));
		$dateDebut = date("Y-m-d");
		date_sub($dateToday, date_interval_create_from_date_string('30 days'));
		$dateFin = date_format($dateToday, 'Y-m-d');
		$query = "SELECT
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
                  WHERE identifiantResp = '$identifiant'
				  AND dateDebut BETWEEN '$dateFin' AND '$dateDebut'";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	function getCompta()
	{
		global $conn;
		$query = "SELECT DISTINCT
						DATEDIFF(dateFin, dateDebut)*forfaitJours AS Duree, 
						prenomSal AS Prenom,
						nomSal AS Nom,
						ca.nomCommune,
						cm.nomCommune,
						dateDebut as Debut, 
						dateFin AS Fin, 
						valider,
						payer,
						Distance,
						CONCAT(ca.nomCommune, '(', ca.cpCommune, ')') AS Lieu,
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
				WHERE m.valider = '1'";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
?>