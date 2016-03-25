<?php
	session_start();
	$identyfikator = $_POST['identyfikator'];
	$klucz = $_POST['klucz'];

	if(!isset($_POST['identyfikator'])&&!isset($_POST['klucz']))
	{
?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
				</ul>
			</div>
		<section class="content">
			<hr>
      			<div class="login">
				<h1>Logowanie </h1>
				<form method="post" action="logowanie.php">
					<p class="infoI">
						<br />
						<label>
							<b><font size="1">Aby uzyskać dostęp do konta podaj identyfikator i klucz</font></b>
						</label>
					</p>
					<p>
						<input type="text" name="identyfikator" value="" placeholder="Identyfikator">
					</p>
					<p>
						<input type="password" name="klucz" value="" placeholder="Klucz">
					</p>
					<p class="submit">
						<center><input type="submit" name="zatwierdz" value="ZATWIERDŹ"></center>
					</p>
				</form>
			</div>
			<hr>
   		</section>
		
		<div class="footer">
        		 	&copy; 2015 eBank Polska S.A. Wszelkie prawa zastrzeżone.
   		</div>
		</div>
	</body>
</html>

<?php
	}
	else
	{
		$mysql = mysql_pconnect("localhost","root","Arbeit!016");
      		//$mysql -> query("SET NAMES 'utf8'");
      		if(!$mysql)
		{
			echo 'Brak połączenia z bazą danych.';
			exit;
		}
		$wybrana = mysql_select_db("ebank");

		if(!$wybrana)
		{
			echo 'Błąd wyboru bazy danych.';
			exit;
		}

		$zapytanie = "select count(*) from uzytkownik where identyfikator = '$identyfikator' and klucz = '$klucz'";
		$zapytanieImie = "select imie from klient join uzytkownik on klient.id_uzytkownik = uzytkownik.id_uzytkownik where identyfikator = '$identyfikator' and klucz = '$klucz'";
		$zapytanieNazwisko = "select nazwisko from klient join uzytkownik on klient.id_uzytkownik = uzytkownik.id_uzytkownik where identyfikator = '$identyfikator' and klucz = '$klucz'";

		$wynik = mysql_query( $zapytanie );
		$wynikImie = mysql_query( $zapytanieImie );
		$wynikNazwisko = mysql_query( $zapytanieNazwisko );

		if(!$wynik)
		{
			echo 'Nie można wykonać zapytania.';
			exit;
		}

		$wiersz = mysql_fetch_row( $wynik );
		$wiersz2 = mysql_fetch_row( $wynikImie );
		$wiersz3 = mysql_fetch_row( $wynikNazwisko );
		$ile = $wiersz[0];
		$imie = $wiersz2[0];
		$nazwisko = $wiersz3[0];

		
		if(!$wynik)
		{
			echo 'Nie można wykonać zapytania.';
			exit;
		}
		
		if ( $ile > 0 )
		{
			$row = mysqli_fetch_array($result);
			$_SESSION['prawid_uzyt'] = array();
	 		$_SESSION['prawid_uzyt']['imie'] = $imie;
	 		$_SESSION['prawid_uzyt']['nazwisko'] = $nazwisko;
	 		header("Location: home.php");
		}
      		else
		{
      			echo 
				'<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
				</ul>
			</div>
		<section class="content">
			<hr>
      			<div class="login">
				<h1>Logowanie </h1>
				<form method="post" action="logowanie.php">
					<p class="infoI">
						<label>
							<b><font size = "1" color="red">Proszę wpisać prawidłowy "Identyfikator" i "Klucz"</font></b>
						</label>
						<br />
						<label>
							<b><font size="1">Aby uzyskać dostęp do konta podaj identyfikator i klucz</font></b>
						</label>
					</p>
					<p>
						<input type="text" name="identyfikator" value="" placeholder="Identyfikator">
					</p>
					<p>
						<input type="password" name="klucz" value="" placeholder="Klucz">
					</p>
					<p class="submit">
						<center><input type="submit" name="zatwierdz" value="ZATWIERDŹ"></center>
					</p>
				</form>
			</div>
			<hr>
   		</section>
		
		<div class="footer">
        		 	&copy; 2015 eBank Polska S.A. Wszelkie prawa zastrzeżone.
   		</div>
		</div>
	</body>
</html>';
		}
	}
?>
