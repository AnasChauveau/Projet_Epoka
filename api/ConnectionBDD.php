<?php

    $dsn = "mysql:dbname=epoka;host=localhost";
    $username = "root";
    $password = "root";
	try{
		$conn = new PDO($dsn, $username, $password);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
?>