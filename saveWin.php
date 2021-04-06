<?php

	require_once "seged.php";
	
	$kapcsolat = dbKapcsolodas(); 
	
	if(count(lekerdezes($kapcsolat,"SELECT `megoldo` FROM `megoldasok` WHERE `palyaazon` = :palyaazon and `megoldo` = :megoldo",
		[ ":palyaazon" => $_GET['level'], ":megoldo" => felhasznalonev()])) == 0){
			vegrehajtas($kapcsolat, "INSERT INTO `megoldasok` (palyaazon, megoldo) VALUES (:palyaazon, :megoldo)", 
			[":palyaazon" => $_GET['level'], ":megoldo" => felhasznalonev()]);
	}
	
	$adatok = lekerdezes($kapcsolat,
			"SELECT `megoldo` FROM `megoldasok` WHERE `palyaazon` = :palyaazon",
			[ ":palyaazon" => $_GET['level'] ]);
	
	$s = "";
	foreach($adatok as $adat){
		$s .= $adat[0]."\n";
	}

	echo $s;
	


?>