<?php

	require_once "seged.php";

	if($_POST){
		if(isset($_POST['palyaazon']) && isset($_POST['nehezseg']) && isset($_POST['palya']) && isset($_POST['falak']) && isset($_POST['ido'])){
			$kapcsolat = dbKapcsolodas();
			$palya = trim(preg_replace('/\s\s+/', '', $_POST['palya']));
			vegrehajtas($kapcsolat, "INSERT INTO `palyak` (palyaazon, nehezseg, palya, falak, ido) VALUES (:palyaazon, :nehezseg, :palya, :falak, :ido)", 
			[ ":palyaazon" => $_POST['palyaazon'], ":nehezseg" => $_POST['nehezseg'], ":palya" => $palya, ":falak" => $_POST['falak'], ":ido" => $_POST['ido'] ]);	
		}
	}
	header("Location: palyak.php");
	exit();
?>