<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
            getParametre();

        case 'PUT':
			print_r($request_method);
            putParametre();
	
		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
	}

    function getParametre()
	{
		global $conn;
		$req = "SELECT *
                  FROM parametre";
		$req = $conn->prepare($req);
		$req->execute();
		$row = $req->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($row)){
			foreach ($row as $item){
				echo json_encode($item);
			}
		}else{
			$errJson = '{
				"err": true,
				"erreur":"Aucun parametre trouvé !"
			}';
			echo ($errJson);
		}	
	}


    function putParametre()
	{

        global $conn;
		$_PUT = array(); //tableau qui va contenir les données reçues
		parse_str(file_get_contents('php://input'), $_PUT);
		$forfaitJour = $_PUT["forfaitJour"];
		$forfaitKm = $_PUT["forfaitKm"];

		//construire la requête SQL
		$req = "UPDATE parametre 
                  SET forfaitJours = $forfaitJour, 
                  forfaitKm = $forfaitKm";
		
		$req = $conn->prepare($req);
		if($req->execute())
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