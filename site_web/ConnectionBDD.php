<?php

    $dsn = "mysql:dbname=epoka;host=localhost;charset=utf8;";
    $username = "root";
    $password = "root";
	try{
		$conn = new PDO($dsn, $username, $password);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
?>