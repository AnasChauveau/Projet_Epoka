<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");


	header("HTTP/1.0 200 Method Not Allowed");
	if (isset($_POST["dateDebut"]) && !empty($_POST["dateDebut"]) 
	&& isset($_POST["dateFin"]) && !empty($_POST["dateFin"]) 
	&& isset($_POST["identifiant"]) && !empty($_POST["identifiant"]) 
	&& isset($_POST["idCommune"]) && !empty($_POST["idCommune"])){
		$dateDebut = $_POST["dateDebut"];
		$dateFin = $_POST["dateFin"];
		$identifiant = $_POST["identifiant"];
		$idCommune = $_POST["idCommune"];
		newMission($identifiant, $idCommune, $dateDebut, $dateFin);
	}else{
		$errJson = [
				   		["err" => "1", "erreur" => "Veuillez vérifier les champs !"]
				   ];
		echo json_encode($errJson);
	}

	function newMission($identifiantSal, $Id_Commune, $dateDebut, $dateFin)
	{
		global $conn;
		$err = false;
		$req = "INSERT INTO mission (identifiantSal, Id_Commune, dateDebut, dateFin, valider, payer) 
		VALUES (:identifiantSal, :Id_Commune, :dateDebut, :dateFin, 0, 0);";
		$req = $conn->prepare($req);
		$req->bindParam(':identifiantSal', $identifiantSal);
		$req->bindParam(':Id_Commune', $Id_Commune);
		$req->bindParam(':dateDebut', $dateDebut);
		$req->bindParam(':dateFin', $dateFin);
		$req->execute();	
	}
?>