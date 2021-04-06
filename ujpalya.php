<?php

	require_once "seged.php";
	
					
				/*<form action="saveLevel.php" method="post">
				
					Pályanév (egyedi): <br>
						<input type="text" name="palyaazon" value="<?= $palyaazon ?? '' ?>">
						<br>
					Nehézség: <br>
						<input type="text" name="nehezseg" value="<?= $nehezseg ?? '' ?>">
						<br>
					Pálya: <br>
						<input type="text" class="textarea" placeholder="formátum: ▩▩▩▩▩◼▩▩▩▩▩,▩▩◼↑▩▩▩✹▩▩▩,▩▩▩↑▩▩▩▩▩▩▩,▩▩▩⮤←←←←↺▩▩,▩▩▩▩▩▩▩▩▩▩▩,▩◼▩▩▩▩▩⮘▩▩▩" name="palya" value="<?= $palya ?? '' ?>">
						<br>
					Falak: <br>
						<input type="text" class="textarea" placeholder='formátum: [{"i": 4, "j": 5, "side": "top"},{"i": 4, "j": 5, "side": "left"}]' name="falak" value="<?= $falak ?? '' ?>">
						<br>
					Idő (milisec): <br>
						<input type="text" name="ido" value="<?= $ido ?? '' ?>">
						<br>
					
				</form>*/

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
			
			<?php if (azonositott_e() && felhasznalonev()=="admin") : ?>
				<div id="menu" class="menu">
				
					<form action="palyak.php">
						<input type="submit" class="button" value="Vissza" />
					</form>

				<br><br>
				<form action="saveLevel.php" method="post" id="ujpalyaForm">
				
					Pályanév (egyedi): <br>
						<input type="text" name="palyaazon" value="<?= $palyaazon ?? '' ?>">
						<br>
					Nehézség: <br>
						<select name="nehezseg">
							<option value="könnyű">könnyű</option>
							<option value="közepes">közepes</option>
							<option value="nehéz">nehéz</option>
						</select>
						<br>
					Pálya: <br>
						<div class="szimbolumok">pályaszimbólumok:<br>
						▩◼✹←↑→↓<br>
						⮠⮣⮤⮧⮡⮢⮥⮦<br>
						↺↻⮘⮙⮚⮛</div>
						<br>
						<textarea name="palya" class="textarea" form="ujpalyaForm">formátum: 
▩▩▩▩▩◼▩▩▩▩▩,
▩▩◼↑▩▩▩✹▩▩▩,
▩▩▩↑▩▩▩▩▩▩▩,
▩▩▩⮤←←←←↺▩▩,
▩▩▩▩▩▩▩▩▩▩▩,
▩◼▩▩▩▩▩⮘▩▩▩</textarea>
						<br>
					Falak: <br>
						<textarea name="falak" class="textarea" form="ujpalyaForm">formátum: [{"i": 4, "j": 5, "side": "top"},{"i": 4, "j": 5, "side": "left"}]</textarea>
						<br>
					Idő (milisec): <br>
						<input type="text" name="ido" value="<?= $ido ?? '' ?>">
						<br><br>
					
					<input type="submit" class="button" value="Pálya felvétele">
					
				</form>
				
				<br><br><hr><br><br>
				
				<form action="deleteLevel.php" method="post" id="palyatorles">
				
					Pályanév (egyedi): <br>
						<input type="text" name="palyaazon" value="<?= $palyaazon ?? '' ?>">
						<br><br>
					
					<input type="submit" class="button" value="Pálya törlése">
					
				</form>
				<br><br><br>
				
				</div>
			<?php else: ?>
				<?php header("Location: index.php"); exit(); ?>
			<?php endif; ?>
			
			
	</body>
	
</html> 