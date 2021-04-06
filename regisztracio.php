<?php

	require_once "seged.php";
	
	if($_POST){
		
		$nev = "";
		$email = "";
		$jelszo = "";
		
		$hibak = [];
		$hibak = array_merge(jelszoEllenorzes(), nevEllenorzes(), emailEllenorzes());
		
		echo count($hibak);
		
		/*if(isset($_POST['nev']) && $_POST['nev']!=""){
			$nev = $_POST['nev'];
		} else {
			$hibak = [];
			array_push($hibak, "Név megadása kötelező!");
		}
	
		if(isset($_POST['email'])){
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ //preg_match("/^+@+$/", $_POST['email']) v strpos($_POST['email'],"@")
				if(isset($hibak)){
					array_push($hibak, "Nem valid az email cím!");
				} else {
					$hibak = [];
					array_push($hibak, "Nem valid az email cím!");
				}
			} else {
				$email = $_POST['email'];
			}
		} else {
			if(isset($hibak)){
				array_push($hibak, "Emailcím megadása kötelező!");
			} else {
				$hibak = [];
				array_push($hibak, "Emailcím megadása kötelező!");
			}
		}
	
		if(isset($_POST['jelszo']) && $_POST['jelszo']!=""){
			$jelszo = $_POST['jelszo'];
		} else {
			if(isset($hibak)){
				array_push($hibak, "Jelszó megadása kötelező!");
			} else {
				$hibak = [];
				array_push($hibak, "Jelszó megadása kötelező!");
			}
		}*/
		
		if(count($hibak) === 0){
			$kapcsolat = dbKapcsolodas();
			
			if(letezik($kapcsolat, "email", $email)){
				array_push($hibak, "Ez az email már regisztrálva van!");
			}
			if(letezik($kapcsolat, "nev", $nev)){
				array_push($hibak, "Ez a felhasználónév már regisztrálva van!");
			}
			
			if(count($hibak) === 0){
				regisztral($kapcsolat, $nev, $email, $jelszo);
			}
		}
	}
	
	function letezik($kapcsolat, $adatnev, $adat) {
		$adatok = lekerdezes($kapcsolat,
			"SELECT * FROM `adatok` WHERE `$adatnev` = :$adatnev",
			[ ":".$adatnev => $adat ]
		);
		return count($adatok) === 1;
	}
	
	function regisztral($kapcsolat, $nev, $email, $jelszo) {
		vegrehajtas($kapcsolat, "INSERT INTO `adatok` (nev, email, jelszo) VALUES (:nev, :email, :jelszo)", 
			[":nev" => $nev, ":email" => $email, ":jelszo" => $jelszo]);	
		header("Location: siker.php");
		exit();
	}
	
	/*function getParameter($kulcs, $default){
		if(isset($_GET[$kulcs]) && $_GET[$kulcs] != '') {
			return $_GET[$kulcs];
		}
		if(isset($_POST[$kulcs]) && $_POST[$kulcs] != '') {
			return $_POST[$kulcs];
		}
		return $default;
	}*/
	
	function nevEllenorzes(){
		if(isset($_POST['nev']) && $_POST['nev']!=""){
			$GLOBALS['nev'] = $_POST['nev'];
			return [];
		} else {
			return["Név megadása kötelező!"];
		}
	}
	
	function emailEllenorzes(){
		if(isset($_POST['email'])){
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ //preg_match("/^+@+$/", $_POST['email']) v strpos($_POST['email'],"@")
				return ["Nem valid az email cím!"];
			} else {
				$GLOBALS['email'] = $_POST['email'];
				return [];
			}
		} else {
			return ["Emailcím megadása kötelező!"];
		}
	}
	
	function jelszoEllenorzes(){
		if(isset($_POST['jelszo']) && $_POST['jelszo']!=""){
			$GLOBALS['jelszo'] = $_POST['jelszo'];
			return [];
		} else {
			return ["Jelszó megadása kötelező!"];
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Beadandó</title>

		<link href="game.css" rel="stylesheet" media="screen">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
		
	</head>
	<body>
			<h1>Robotkaland</h1>
		
			<div id="menu" class="menu">
			
				<h2>Regisztráció</h2>
			
				<form action="regisztracio.php" method="post">
					Felhasználónév: <input type="text" name="nev" value="<?= $nev ?? '' ?>"><br>
					Emailcím: <input type="text" name="email" placeholder="nev@gmail.com"value="<?= $email ?? '' ?>"><br>
					Jelszó: <input type="password" name="jelszo"><br><br>
					<input type="submit" class="button" value="Regisztrálok">
				</form>
				
				<br>
				
				<?php if (isset($hibak)) : ?>
					<div class="errors">
						<ul>
						<?php foreach($hibak as $hiba) : ?>
							<li><?= $hiba ?></li>
						<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				
			</div>
			
	</body>
	
</html> 