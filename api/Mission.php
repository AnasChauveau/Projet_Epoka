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
				break;
			}else{				
				getCompta();			
				break;
			}
	
		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

    function getProducts($identifiant)	
	{
		global $conn;
		$dateToday = date_create(date("Y-m-d"));
		$dateDebut = date("Y-m-d");
		date_sub($dateToday, date_interval_create_from_date_string('30 days'));
		$dateFin = date_format($dateToday, 'Y-m-d');
		$query = "SELECT
						 DATEDIFF(dateFin, dateDebut) AS Duree, 
                         prenomSal AS Prenom,
                         nomSal AS Nom,
                         dateDebut as Debut, 
                         dateFin AS Fin, 
                         valider,
                         payer 
                  FROM mission m
                  INNER JOIN salarie s ON s.identifiant = m.identifiantSal
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
		$query = "SELECT
                         prenomSal AS Prenom,
                         nomSal AS Nom,
                         dateDebut as Debut, 
                         dateFin AS Fin, 
                         valider,
                         payer 
                  FROM mission m
                  INNER JOIN salarie s ON s.identifiant = m.identifiantSal
                  WHERE m.valider = '0'";
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