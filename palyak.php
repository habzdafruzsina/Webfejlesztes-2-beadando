<?php

	require_once "seged.php";
	
	function debug_to_console( $data ) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);

		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
	
	function palyak(){
		$kapcsolat = dbKapcsolodas();
		$adatok = lekerdezes($kapcsolat, "SELECT * FROM `palyak`", []);
		$s = '<table id="palyak">';
		$s .= '<tr> <td>Pályanév</td> <td>Nehézség</td> <td>Megoldók<br>száma</td> <td>Megoldva</td> </tr>';
		foreach($adatok as $adat){
			$megoldasDb = lekerdezes($kapcsolat, "SELECT COUNT(*) AS count FROM `megoldasok` WHERE `palyaazon` = :palyaazon",
			[ ":palyaazon" => $adat['palyaazon'] ]);
			$megoldasDb = $megoldasDb[0]["count"];
			$megoldva = lekerdezes($kapcsolat, "SELECT COUNT(*) count FROM `megoldasok` WHERE `palyaazon` = :palyaazon AND `megoldo` = :megoldo",
			[ ":palyaazon" => $adat['palyaazon'], ":megoldo" => felhasznalonev()]);
			$megoldva = ($megoldva[0]['count'] == 1) ? "megoldva" : "-";
			$s .= '<tr><td><a href="jatek.php?palya='.$adat["palyaazon"].'">'.$adat["palyaazon"].'</a></td>';
			$s .= '<td>'.$adat["nehezseg"].'</td> <td>'.$megoldasDb.'</td> <td>'.$megoldva.'</td> </tr>';		
		}
		$s .= "</table>";
		echo $s;
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
			
			<?php if (azonositott_e()) : ?>
				<div id="menu" class="menu">
					<div>
						<h3>Üdvözlünk 
						<?php echo felhasznalonev(); ?>
						!</h3>
						<form action="kijelentkezik.php">
							<input type="submit" class="button" value="Kilépés" />
						</form>
						
						<?php if (felhasznalonev()=="admin") : ?>
							<br>
							<form action="ujpalya.php">
								<input type="submit" class="button" value="Új pálya" />
							</form>
						<?php endif; ?>
						
					</div>
					<br>

					<?php echo palyak(); ?>

				
				</div>
			<?php else: ?>
				<?php header("Location: index.php"); exit(); ?>
			<?php endif; ?>
			
			
	</body>
	
</html> 