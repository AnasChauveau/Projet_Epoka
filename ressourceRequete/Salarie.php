<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
			if (isset($_GET["identifiant"]) && !empty($_GET["identifiant"])){
				$identifiant = $_GET["identifiant"];
				if (isset($_GET["mdp"]) && !empty($_GET["mdp"])){
					$mdp = $_GET["mdp"];
					getSalarie($identifiant, $mdp);
				}else{				
					$errJson = '{
						"err": true,
						"erreur":"le mot de passe a été mal saisi!"
					}';
					echo ($errJson);
				}
			}else{
				$errJson = '{
					"err": true,
					"erreur":"l\'identifiant a été mal saisi!"
				}';
				echo ($errJson);
			}
			
		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
	}

    function getSalarie($identifiant, $mdp)
	{
		global $conn;
		$err = false;
		$req = "SELECT identifiant,
                       nomSal,
                       prenomSal
                FROM salarie
				WHERE mdp = :mdp
				AND identifiant = :identifiant";
		$req = $conn->prepare($req);
		$req->bindParam(':mdp', $mdp);
		$req->bindParam(':identifiant', $identifiant);
		$req->execute();
		$row = $req->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($row)){
			foreach ($row as $item){
				echo json_encode($item);
			}
		}else{
			$errJson = '{
				"err": true,
				"erreur":"Il existe pas de compte associé"
			}';
			echo ($errJson);
		}	
		
	}
?>