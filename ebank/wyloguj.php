<?php
	session_start();
	if(isset($_SESSION['prawid_uzyt']))
	{
		session_destroy();
		//echo '<center><h3>Pomyślnie zostałeś wylogowany z naszego serwisu. Wkrótce zostaniesz przekierowany na stronę z logowaniem.</center></h3>';
		//header("Refresh: 4; url=logowanie.php");
	}
?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>eBank Polska S.A.</title>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" href="css/style2.css">
	</head>
	<body>
		<div class="container">
			<div class="header">
				<h1 class="header-heading">eBank</h1>
			</div>
			<div class="nav-bar">
				<ul class="nav">
					<li><a href="home.php">Home</a></li>
					<li><a href="przelew.php">Przelew</a></li>
					<li><a href="doladowanie.php">Doładowanie</a></li>
					<li><a href="historia.php">Historia</a></li>
					<li><a href="pomoc.php">Pomoc</a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href=""></a></li>
					<li><a href="logowanie.php">Zaloguj</a></li>
					<li><a href="wyloguj.php">Wyloguj</a></li>

				</ul>
			</div>
			<div class="content">
				<div class="main">
					<?php 
						session_start();
						if(isset($_SESSION['prawid_uzyt'])) 
						{
						}
					   	else
						{
							echo '<hr><h2><center>Pomyślnie zostałeś wylogowany z naszego serwisu.</center></h2><hr>';
						}
					?>
				</div>
			</div>
			<div class="footer">
				&copy; eBank Polska S.A. Wszelkie prawa zastrzeżone.
			</div>
		</div>
	</body>
</html>
