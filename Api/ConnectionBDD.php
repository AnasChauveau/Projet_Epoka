<?php

    $dsn = "mysql:dbname=zaraco-layenne_epoka;host=mysql-zaraco-layenne.alwaysdata.net;charset=utf8;";
    $username = "251749_valanas";
    $password = "Valanas38";
	try{
		$conn = new PDO($dsn, $username, $password);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
?>