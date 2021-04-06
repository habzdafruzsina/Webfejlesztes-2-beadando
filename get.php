<?php

	require_once "seged.php";
	
	$kapcsolat = dbKapcsolodas(); 
	$adatok = lekerdezes($kapcsolat,
			"SELECT * FROM `palyak` WHERE `palyaazon` = :palyaazon",
			[ ":palyaazon" => $_GET['level'] ]);
	$adat = $adatok[0];
	
	$s = $adat['palya'].';'.$adat['falak'].';'.$adat['ido'];
	
	function debugToConsole($msg) { 
        echo "<script>console.log(".json_encode($msg).")</script>";
	}
	
	echo $s;
			
	/*$level = [
			"board" => json_decode(utf8_encode($adat['palya'])),
			"walls" => json_decode($adat['falak']),
			"time" => json_decode($adat['ido'])
	];

	echo json_encode($level);*/
	
	/*board: [
		"▩▩▩▩▩◼▩▩▩▩▩",
        "▩▩◼↑▩▩▩✹▩▩▩",
        "▩▩▩↑▩▩▩▩▩▩▩",
        "▩▩▩⮤←←←←↺▩▩",
        "▩▩▩▩▩▩▩▩▩▩▩",
        "▩◼▩▩▩▩▩⮘▩▩▩",
    ],
    walls: [
        {i: 4, j: 5, side: "top"},
        {i: 4, j: 5, side: "left"},
    ],
    time: 10000*/
	
	/*{"board":["▩▩▩▩▩◼▩▩▩▩▩","▩▩◼↑▩▩▩✹▩▩▩","▩▩▩↑▩▩▩▩▩▩▩","▩▩▩⮤←←←←↺▩▩","▩▩▩▩▩▩▩▩▩▩▩","▩◼▩▩▩▩▩⮘▩▩▩"],
	"walls":[{"i":4,"j":5,"side":"top"},{"i":4,"j":5,"side":"left"}],
	"time":10000}
	
	$file = file_get_contents("adat10.json");
	
	
	$adatok = json_decode($file, true);

	if($_GET['oldal']){
		$oldal = $_GET['oldal'];
		$adatok = array_slice($adatok, ($oldal-1)*5, 5);
		echo json_encode($adatok);	
	}*/
	


?>