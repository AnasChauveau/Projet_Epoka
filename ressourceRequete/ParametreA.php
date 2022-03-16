<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
            getParametre();

        case 'POST':
            if (isset($_POST["forfaitJours"]) && !empty($_POST["forfaitJours"])){
				$forfaitJour = $_POST["forfaitJours"];
				if (isset($_POST["forfaitKm"]) && !empty($_POST["forfaitKm"])){
					$forfaitKm = $_POST["forfaitKm"];
					putParametre($forfaitJours, $forfaitkm);
				}else{				
					$errJson = '{
						"err": true,
						"erreur":"le champs forfaitKm a été mal saisi!"
					}';
					echo ($errJson);
				}
			}else{
				$errJson = '{
					"err": true,
					"erreur":"Le champs forfaitJours a été mal saisi!"
				}';
				echo ($errJson);
			}
	
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


    function putParametre($forfaitJours, $forfaitkm)
	{
        global $conn;
		//construire la requête SQL
		$req = "UPDATE parametre 
                  SET forfaitJours = :forfaitJours, 
                  forfaitKm = :forfaitKm";
		
		$req = $conn->prepare($req);
		$req->bindParam(':forfaitJours', $forfaitJours);
		$req->bindParam(':forfaitKm', $forfaitKm);

		if($req->execute()){
			$errJson = '{
                "err": false,
                "erreur":"Produit mis a jour avec succes."
            }';
            echo ($errJson);
		}else{
			$errJson = '{
                "err": true,
                "erreur":"Echec de la mise a jour de produit."
            }';
            echo ($errJson);
		}
	}
?>