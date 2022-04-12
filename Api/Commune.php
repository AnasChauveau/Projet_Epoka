<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");


	header("HTTP/1.0 200 Method Not Allowed");
	getCommune();
	
	
			

    function getCommune()
	{
		global $conn;
		$err = false;
		$req = "SELECT idCommune AS ID, CONCAT(c.nomCommune, ' (' , c.cpCommune, ')', idCommune) AS Commune, false AS err FROM commune c";
		$req = $conn->prepare($req);
		$req->execute();
		$row = $req->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($row)){

			echo json_encode($row);		
		}else{
			$errJson = [
							["err" => "1", "erreur" => "Pas de commune !"]
					   ];
			echo json_encode($errJson);
		}		
	}
?>