<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
            getParametre();

        case 'PUT':
            putParametre();
	
		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
	}

    function getParametre()
	{
		global $conn;
		$query = "SELECT *
                  FROM parametre p";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row; 
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}


    function putParametre()
	{

        global $conn;
		$_PUT = array(); //tableau qui va contenir les données reçues
		parse_str(file_get_contents('php://input'), $_PUT);
		$forfaitJour = $_PUT["forfaitJour"];
		$forfaitKm = $_PUT["forfaitKm"];

		//construire la requête SQL
		$query = "UPDATE parametre 
                  SET forfaitJours = $forfaitJour 
                  AND forfaitKm = $forfaitKm";
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit mis a jour avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Echec de la mise a jour de produit. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
?>