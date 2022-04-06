<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");


	header("HTTP/1.0 200 Method Not Allowed");
	echo json_encode($errJson);
	}
			

    function getSalarie($identifiant, $mdp)
	{
		global $conn;
		$err = false;
		$req = "";
		$req = $conn->prepare($req);
		$req->bindParam(':mdp', $mdp);
		$req->bindParam(':identifiant', $identifiant);
		$req->execute();
		
	}
?>