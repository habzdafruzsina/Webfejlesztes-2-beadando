<?php
	
	require_once "seged.php";
	
	if($_POST){
		
		/*session_start();
		function azonositott_e() {
		  return isset($_SESSION["felhasznalo"]);
		}
		
		function kijelentkeztet() {
			unset($_SESSION["felhasznalo"]);
		}
		
		session_start();
		if (!azonositott_e()) {
			header("Location: bejelentkezik.php");
			exit();
		}*/
		
		$email = "";
		$jelszo = "";
		
		$hibak = [];
		$hibak = array_merge(jelszoEllenorzes(), emailEllenorzes());
		
		if(count($hibak) === 0){
			$kapcsolat = dbKapcsolodas();
			$felhasznalo = jelszotEllenoriz($kapcsolat, $email, $jelszo);
			if ($felhasznalo === false){
				array_push($hibak, 'Hibás emailcím vagy jelszó!');
			} else {
				beleptet($felhasznalo);
				header("Location: palyak.php");
				exit();
			}
		}
		
	}
	
	function jelszotEllenoriz($kapcsolat, $email, $jelszo) {
		$adatok = lekerdezes($kapcsolat, "SELECT * FROM `adatok` WHERE `email` = :email",
		[ ":email" => $email ]);
		if (count($adatok) === 1) {
			$adat = $adatok[0];
			echo $adat["email"];
			echo $adat["jelszo"];
			return ($jelszo == $adat["jelszo"]) ? $adat : false;
		}
		return false;
	}

	function beleptet($felhasznalo) {
		$_SESSION["felhasznalo"] = $felhasznalo;
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
			
			<h2>Bejelentkezés</h2>
			
				<form action="belepes.php" method="post">
					Emailcím: <input type="text" name="email"><br>
					Jelszó:	<input type="password" name="jelszo"><br><br>
					<input type="submit" class="button" value="Bejelentkezek">
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