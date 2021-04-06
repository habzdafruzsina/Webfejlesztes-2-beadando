
<?php

	require_once "seged.php";

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Beadandó - Főoldal</title>

		<link href="game.css" rel="stylesheet" media="screen">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
		
	</head>
	<body>
			<h1>Robotkaland</h1>
		
			<div id="menu" class="menu">
			
			<?php if (azonositott_e()) : ?>
				<div>
					<h3>Üdvözlünk 
					<?php echo felhasznalonev(); ?>
					!</h3>
					<form action="kijelentkezik.php">
						<input type="submit" class="button" value="Kilépés" />
					</form>
					<br>
					<form action="palyak.php">
						<input type="submit" class="button" value="Pályák" />
					</form>
					
				</div>
			<?php endif; ?>
			
			
			<?php if (!azonositott_e()) : ?>
				<form action="belepes.php" method="post">
					<input type="submit" class="button" value="Belépés">
				</form>
				
				<br>
				
				<form action="regisztracio.php" method="post">
					<input type="submit" class="button" value="Regisztráció">
				</form>
			<?php endif; ?>
			
				<img src="wall_e.jpg" alt="wall-e">
				<h2>Story</h2>
				<p>Wall-E, a kis robot egy hatalmas űrhajó alsó szintjén a gépházban dolgozik. Egy nap az űrhajó meteorzáporba kerül, és az egyik meteor lyukat üt az űrhajó testén. A sérülés olyan veszélyes, hogy az automata védelmi rendszer azonnal lezárja ezt a szintet, így emberek nem tudnak a gépházba bemenni. Egyedül Wall-E tartózkodik a gépházban, akinek utasításokat adhatunk. Wall-E memóriája azonban véges, így egyszerre csak 5 parancsot tud megjegyezni és végrehajtani, majd újra és újra be kell őt programozni a következő lépésekre. Ráadásul a meteor a kommunikációs egységet is megrongálta, így mindig csak 9 véletlenszerű utasítás közül választhatjuk ki az 5 parancsot. A dolgot azonban a terep is nehezíti: ami a mindennapi munkát segítette, az most itt akár hátráltathatja is a haladást. A gépházban ugyanis futószalagok, forgatók és gödrök vannak, amelyek befolyásolják a robot mozgását. Segíts Wall-E-nak eljutni a gépházban a sérülés helyére és megjavítani azt!</p>
				<a href="game.html">Próba játék (Eredeti oldal)</a>
			</div>
			
	</body>
	
</html>