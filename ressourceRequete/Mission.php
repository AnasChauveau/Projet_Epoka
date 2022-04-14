<?php
	// Se connecter à la base de données
	include("ConnectionBDD.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	switch($request_method)
	{
		case 'GET':	
			if (isset($_GET["identifiant"]) && !empty($_GET["identifiant"])){
				$identifiant = $_GET["identifiant"];
				getProducts($identifiant);		
			}else{				
				getCompta();			
			}
	
		default:
			// Requête invalide
			header("HTTP/1.0 405 Method Not Allowed");
	}

    function getProducts($identifiant)
	{
		global $conn;
		$err = false;
		$dateToday = date_create(date("Y-m-d"));
		$dateDebut = date("Y-m-d");
		date_sub($dateToday, date_interval_create_from_date_string('30 days'));
		$dateFin = date_format($dateToday, 'Y-m-d');
		$req = "SELECT
                         prenomSal AS Prenom,
                         nomSal AS Nom,
                         dateDebut as Debut, 
                         dateFin AS Fin, 
                         valider,
                         payer,
						 CONCAT(c.nomCommune, '(', c.cpCommune, ')') AS Lieu,
						 CASE 
                         	WHEN valider = 0 THEN ''
                         	WHEN valider = 1 AND payer = 1 THEN CONCAT('Validée, ', 'Remboursée')
                         	WHEN valider = 1 THEN 'Validée'
                         END AS validation 
                  FROM mission m
                  INNER JOIN salarie s ON s.identifiant = m.identifiantSal
				  INNER JOIN commune c ON c.idCommune = m.Id_Commune
                  WHERE identifiantResp = :idRes
				  AND dateDebut BETWEEN :dateFin AND :dateDebut";
		$req = $conn->prepare($req);
		$req->bindParam(':idRes', $identifiant);
		$req->bindParam(':dateFin', $dateFin);
		$req->bindParam(':dateDebut', $dateDebut);
		$req->execute();
		$row = $req->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($row)){
			foreach ($row as $item){
				echo json_encode($item);
			}
		}else{
			$errJson = '{
				"err": true,
				"erreur":"Vous n\'avez aucun subordonné ayant fait une mission dans les 30 derniers jours"
			}';
			echo ($errJson);
		}		
	}

	function getCompta()
	{
		global $conn;
		$err = false;
		$req = "SELECT DISTINCT 
					prenomSal AS Prenom,
					nomSal AS Nom,
					dateDebut as Debut, 
					dateFin AS Fin, 
					payer,
					Distance,
					CONCAT(cm.nomCommune, '(', cm.cpCommune, ')') AS Lieu,
					CASE 
						WHEN isnull(Distance) = 1 AND payer = 0 THEN CONCAT('Distance entre ', ca.nomCommune, ' et ', cm.nomCommune, ' non defini') 
						WHEN payer = 0 THEN (Distance*forfaitKm)+(DATEDIFF(dateFin, dateDebut)*forfaitJours)
						WHEN payer = 1 THEN 'Remboursée'
					END AS remboursement
				FROM salarie s
				INNER JOIN mission m ON m.identifiantSal = s.Identifiant
				INNER JOIN parametre
				INNER JOIN agence a ON a.idAgence = s.Id_Agence
				INNER JOIN commune cm ON cm.idCommune = m.Id_Commune
				INNER JOIN commune ca ON ca.idCommune = a.Id_Commune
				LEFT JOIN relier r ON r.Id_Commune1 = cm.idCommune AND r.Id_Commune2 = ca.idCommune
				WHERE m.valider = '1';";
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
				"erreur":"Aucune mission trouvé !"
			}';
			echo ($errJson);
		}	
	}
?>