<?php 
  session_start();
  if(isset($_SESSION['prawid_uzyt']))
  {
	  echo	'<html lang="en">
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
								<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
	       						<li><a href="wyloguj.php">Wyloguj</a></li>
							</ul>
						</div>
						<div class="content">
							<div class="main">';
	  $mysql = mysql_pconnect("localhost","root","Arbeit!016");
      		
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
	  $imie = $_SESSION['prawid_uzyt']['imie'];
	  $nazwisko = $_SESSION['prawid_uzyt']['nazwisko'];

	  $zapytanieStanKonta = "select stanKonta, numerKonta, dataUrodzenia, ulica, nrDomu, miejscowosc, kodPocztowy, panstwo from konto join klient on konto.id_konto = klient.id_konto where imie = '$imie' and nazwisko = '$nazwisko'";
	  $wynikStanKonta = mysql_query( $zapytanieStanKonta );
	  $wiersz4 = mysql_fetch_row( $wynikStanKonta );
	  $stanKonta = $wiersz4[0];
	  $numerKonta = $wiersz4[1];
	  $dataUrodzenia = $wiersz4[2];
	  $ulica = $wiersz4[3];
	  $nrDomu = $wiersz4[4];
	  $miejscowosc = $wiersz4[5];
	  $kodPocztowy = $wiersz4[6];
	  $panstwo = $wiersz4[7];
								
	  echo '<div><span class="prawa"><h6>Jesteś zalogowany jako:  '.$imie." ".$nazwisko.'</h6></span><span class="lewa"><h2>Home</h2>';
	  echo '</span></div><hr>';
	  echo '<h5> Twój numer konta: <b>'.$numerKonta.'</b></h5><br />';
	  echo '<h5> Bieżący stan Twojego konta: <b>'.$stanKonta.'</b> PLN</h5><br /><br /><br />';
	  echo '<h5>Twoje dane osobowe: </h5><hr>';
	  echo '<h5>Imię i nazwisko: <b>'.$imie.' '.$nazwisko.'</b><br />Data urodzenia: <b>'.$dataUrodzenia.'</b></h5><br />';
	  echo '<h5>Adres zamieszkania: <b>'.$ulica.' '.$nrDomu.', '.$kodPocztowy.' '.$miejscowosc.', '.$panstwo.'</b></h5><br />';
	  echo '<hr>';
	  echo '</div>
					</div>
					<div class="footer">
						&copy; eBank Polska S.A. Wszelkie prawa zastrzeżone.
					</div>
					</div>
					</body>
			</html>';
	}
	else
	{
		header("Refresh: 0; url=niezalogowany.php");
	}
?>
