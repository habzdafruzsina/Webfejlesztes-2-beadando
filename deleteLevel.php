<?php

	require_once "seged.php";
	
	if(isset($_POST['palyaazon'])){
		$kapcsolat = dbKapcsolodas();
		vegrehajtas($kapcsolat, "DELETE FROM `palyak` WHERE `palyaazon` = :palyaazon", [ ":palyaazon" => $_POST['palyaazon'] ]);
		vegrehajtas($kapcsolat, "DELETE FROM `megoldasok` WHERE `palyaazon` = :palyaazon", [ ":palyaazon" => $_POST['palyaazon'] ]);
	}
	header("Location: palyak.php");
	exit();

?>