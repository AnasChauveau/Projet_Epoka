<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");


	header("HTTP/1.0 200 Method Not Allowed");
	if (isset($_GET["identifiant"]) && !empty($_GET["identifiant"])){
		$identifiant = $_GET["identifiant"];
		if (isset($_GET["mdp"]) && !empty($_GET["mdp"])){
			$mdp = $_GET["mdp"];	
			getSalarie($identifiant, $mdp);
		}else{		
			$errJson = [
					   		["err" => "1", "erreur" => "le mot de passe a été mal saisi !"]
					   ];		
			echo json_encode($errJson);
		}
	}else{
		$errJson = [
				   		["err" => "1", "erreur" => "l'identifiant a été mal saisi !"]
				   ];
		echo json_encode($errJson);
	}
			

    function getSalarie($identifiant, $mdp)
	{
		global $conn;
		$err = false;
		$req = "SELECT identifiant,
                       nomSal,
                       prenomSal,
					   false AS err
                FROM salarie
				WHERE mdp = :mdp
				AND identifiant = :identifiant";
		$req = $conn->prepare($req);
		$req->bindParam(':mdp', $mdp);
		$req->bindParam(':identifiant', $identifiant);
		$req->execute();
		$row = $req->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($row)){

			echo json_encode($row);		
		}else{
			$errJson = [
							["err" => "1", "erreur" => "Il n'existe pas de compte associé !"]
					   ];
			echo json_encode($errJson);
		}
		
	}
?>