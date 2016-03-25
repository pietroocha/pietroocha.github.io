<?php
session_start();
if(isset($_SESSION['prawid_uzyt'])) {
    echo '<html lang="en">
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
    $mysql = mysql_pconnect("localhost", "root", "Arbeit!016");

    if (!$mysql) {
        echo 'Brak połączenia z bazą danych.';
        exit;
    }
    $wybrana = mysql_select_db("ebank");

    if (!$wybrana) {
        echo 'Błąd wyboru bazy danych.';
        exit;
    }
    $imie = $_SESSION['prawid_uzyt']['imie'];
    $nazwisko = $_SESSION['prawid_uzyt']['nazwisko'];

    $zapytanieStanKonta = "select stanKonta, numerKonta from konto join klient on konto.id_konto = klient.id_konto where imie = '$imie' and nazwisko = '$nazwisko'";
    $wynikStanKonta = mysql_query($zapytanieStanKonta);
    $wiersz4 = mysql_fetch_row($wynikStanKonta);
    $stanKonta = $wiersz4[0];
    $numerKonta = $wiersz4[1];

    $zapytanieIdKonto = "select id_konto from konto where numerKonta = '$numerKonta' and stanKonta = '$stanKonta'";
    $wynikIdKonto = mysql_query($zapytanieIdKonto);
    $wiersz5 = mysql_fetch_row($wynikIdKonto);
    $idKonto = $wiersz5[0];

    echo '<div><span class="prawa"><h6>Jesteś zalogowany jako:  ' . $imie . " " . $nazwisko . '</h6></span><span class="lewa"><h2>Doładowanie telefonu</h2>';
    echo '</span></div><hr>';
    echo 'Tutaj możesz doładować telefon wpisując nazwę sieci oraz kwotę doładowania. Po poprawnym wprowadzeniu danych uzyskasz kod doładowujący.<br />Sieci jakie obsługujemy to: <b>t-mobile</b>, <b>play</b>, <b>plus</b> oraz <b>orange</b>. <hr>';
    echo '<form method="post" action="doladowanie.php">';
    echo '<center>Nazwa sieci:&nbsp<input type="text" style="width: 105px;" name="nazwaSieci" placeholder="" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br />';
    echo 'Kwota:&nbsp<input type="text" style="width: 105px;" name="kwotaDol" value="" placeholder="" /> PLN</center>';
    echo '<p class="submit"><center><input type="submit" name="uzyskajKod" value="UZYSKAJ KOD"></p><hr>';
    echo '</form>';
    $kodDol = '';
    $counter = 0;
    while ($counter < 11) {
        $l = rand(1, 9);
        $kodDol = $kodDol . $l;
        $counter++;
    }
    //echo $kodDol;
    $nazwaSieci = $_POST['nazwaSieci'];
    $kwotaDol = $_POST['kwotaDol'];
    if (!isset($_POST['nazwaSieci'])&&!isset($_POST['kwotaDol'])) {
        echo '<br /><br /><hr><div><span class="prawa"><h6>Stan Twojego konta: ' . $stanKonta . ' PLN </h6></span><span class="lewa"><h6>Numer Twojego konta: ' . $numerKonta . '</span></div><hr>';
    } else {
        $mysql = mysql_pconnect("localhost", "root", "Arbeit!016");

        if (!$mysql) {
            echo 'Brak połączenia z bazą danych.';
            exit;
        }
        $wybrana = mysql_select_db("ebank");

        if (!$wybrana) {
            echo 'Błąd wyboru bazy danych.';
            exit;
        }

        if (!($nazwaSieci == 't-mobile') && !($nazwaSieci == 'play') && !($nazwaSieci == 'plus') && !($nazwaSieci == 'orange')) {
            echo '<center><font color="red">Niepoprawna nazwa sieci. Obsługujemy wyłącznie sieci:<br /> <b>t-mobile</b>, <b>play</b>, <b>plus</b> oraz <b>orange</b></font></center>';
            echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: ' . $stanKonta . ' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: ' . $numerKonta . '</span></div><hr>';
        }
        else if(($kwotaDol == '' || $kwotaDol < 5) || $kwotaDol > $stanKonta)
        {
            echo '<center><font color="red">Niepoprawna kwota.<br /> Możesz otrzymać kod doładowujący min za <b>5</b> PLN</font></center>';
            echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$stanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
        }
        else
        {
            $nowyStanKonta = $stanKonta - $kwotaDol;

            $zapytanieZmianaStanuKonta = "update konto set stanKonta = '$nowyStanKonta' where numerKonta = '$numerKonta'";
            $wynikZmianaStanuKonta = mysql_query( $zapytanieZmianaStanuKonta );
            $date = date("Y-m-d H:i:s");
            $zapytanieInsertTabDoladowanie = "insert into doladowanie (id_konto, nazwaSieci, kwotaDoladowania, stanKontaPoDoladowaniu, kodDoladowania, dataDoladowania) values ('$idKonto', '$nazwaSieci', '$kwotaDol', '$nowyStanKonta', '$kodDol', '$date')";
            $wynikInsertTabDoladowanie = mysql_query( $zapytanieInsertTabDoladowanie );
            echo '<center>Twój kod doładowujący do sieci <b>'.$nazwaSieci.'</b> o wartości <b>'.$kwotaDol.'</b> PLN to: <br /><font color="green"><h2><b>'.$kodDol.'</b></h2></font></b></center>';
            echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$nowyStanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego konta: '.$numerKonta.'</span></div><hr>';
        }
    }
}
else
{
    header("Refresh: 0; url=niezalogowany.php");
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