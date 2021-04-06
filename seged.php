<?php

	session_start();

	function azonositott_e() {
		return isset($_SESSION["felhasznalo"]);
	}

	function kijelentkeztet() {
		unset($_SESSION["felhasznalo"]);
	}
	
	function felhasznalonev() {
		$felhasznalo = $_SESSION["felhasznalo"];
		return $felhasznalo["nev"];
	}
	
	function lekerdezes($kapcsolat, $sql, $parameterek = []) {
	  $stmt = $kapcsolat->prepare($sql);
	  $stmt->execute($parameterek);
	  return $stmt->fetchAll();
	}

	function vegrehajtas($kapcsolat, $sql, $parameterek = []) {
	  return $kapcsolat
		->prepare($sql)
		->execute($parameterek);
	}
	
	function kapcsolodas($kapcsolati_szoveg, $felhasznalonev = '', $jelszo = '') {
	  $pdo = new PDO($kapcsolati_szoveg, $felhasznalonev, $jelszo);
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $pdo->exec("set names utf8");
	  return $pdo;
	}

	function dbKapcsolodas(){
		$dbConnString = "mysql:host=localhost;dbname=wf2_xnuhte";
		$dbUsername = "xnuhte";
		$dbPassword = "xnuhte";
		return kapcsolodas($dbConnString, $dbUsername, $dbPassword);
	}

?>