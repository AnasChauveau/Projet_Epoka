<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
            getSalarie();
            break;

		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

    function getSalarie()
	{
		global $conn;
		$query = "SELECT 
                    identifiant,
                    nomSal,
                    prenomSal, 
                    password 
                  FROM salarie";

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