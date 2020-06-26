<!DOCTYPE html>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="Styles/addPost.css?v=1" />
        <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
		<link rel="icon" href="icon.png"/>
    	<title>PiesApp</title>
	</head>
	<body onLoad="onLoad()">
		<?php
            $hostname = "localhost";
            $username = "zset_piesapp";
            $password = "tz9JvTUhO9";
            $db = "zset_piesapp";

            $dbconnect=mysqli_connect($hostname,$username,$password,$db);

            if ($dbconnect->connect_error) {
            die("Database connection failed: " . $dbconnect->connect_error);
            }
			$userid=-21;
			$login="";
			if($_COOKIE['login']!="" && $_COOKIE['password']!=""){
				$login=$_COOKIE['login'];
				$upassword=$_COOKIE['password'];
				if($login!="" && $upassword!=""){
					$sql = mysqli_query($dbconnect, "SELECT * FROM Users WHERE Login='{$login}'");
					while ($row = mysqli_fetch_array($sql)) {
						if(password_verify($upassword, $row['Haslo'])){
							$userid=$row['ID'];
						}   
					}
				}
			}
			if($userid<=0){
				header('Location: login.php');
			}
		?>
		<div class="main">
			<div id="main">
			<?php
			$pdf="<b>Zobowiązanie do umowy ................</b><br/><br/>Zawarte dnia...............";
			if($userid>0){
				$sql = mysqli_query($dbconnect, "SELECT * FROM Users WHERE ID LIKE '{$userid}'");
				while ($row = mysqli_fetch_array($sql)) {
					$pdf= $pdf . "
					<p>{$row['Instytucja']}<br/>
					{$row['Adres']}, {$row['Miasto']}<br/>
					tel. {$row['NrTelefonu']}<br/>
					zwanym dalej <b>Schroniskiem</b>,<br/>
					</p>";
				}
			}
			$pdf= $pdf . "a,<br/><br/>
			Imię i nazwisko:<br/>
			Adres:<br/>
			PESEL/REGON:<br/>
			tel:<br/>
			mail:<br/>
			zwanym dalej <b>Adoptującym</b>,
			";
			if($userid>0){
				$sql = mysqli_query($dbconnect, "SELECT * FROM Zwierzaczki WHERE ID LIKE '{$_POST['id']}'");
				while ($row = mysqli_fetch_array($sql)) {
					$pdf= $pdf .  "
					<p>
					Umowa dotyczy adopcji:<br/>
					1. Imię: {$row['Tytul']}<br/>
					2. Płeć: {$row['Plec']}<br/>
					3. Gatunek: {$row['Typ']}<br/>
					4. Rasa: {$row['Rasa']}<br/>
					5. Umaszczenie: {$row['Umaszczenie']}<br/>
					6. Cechy szczególne: {$row['Cechy']}<br/>
					</p>";
				}
			}
			echo "{$pdf}";
			?>
			</div>
		</div>
	</body>
</html>