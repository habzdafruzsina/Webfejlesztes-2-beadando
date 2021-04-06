<?php

	require_once "seged.php";

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
						<h3>
						<?php echo $_GET['palya']; ?>
						</h3>
						
						<form action="palyak.php">
							<input type="submit" class="button" value="Vissza" />
						</form>
						
					</div>
					<br>
					
					<p id="timer" class="timer"></p>
		
					<table id="board" class="board"></table>
					<br>
					<table id="cards" class="board"></table>
					<table id="memory" class="board"></table>
					
					<p id="text"></p>

					<script type="text/javascript" src="game2.js"></script>
				
					
				</div>
			<?php else: ?>
				<?php header("Location: index.php"); exit(); ?>
			<?php endif; ?>
			
			
	</body>
	
</html> 