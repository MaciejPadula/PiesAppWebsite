<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="Styles/viewPost.css?v=1" />
		<link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
		<link rel="icon" href="icon.png"/>
		<title>PiesApp</title>
	</head>
	<body>
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
		?>
        <div class="nav">
            <a href='index.php'><img class="logo" src="piesAppLogo.png"></a>
			<form action="index.php" method="post">
				<input type="textbox" class="search" name="fraza" autocomplete="off" onkeypress="return searchKeyPress(event);">
				<script>
				function searchKeyPress(e)
				{
					e = e || window.event;
					if (e.keyCode == 13)
					{
						document.getElementById('sub').click();
						return false;
					}
					return true;
				}
				</script>
				<input id="sub" type="submit" style="display:none" >
			</form>
			<?php
			if($userid>0){
				echo "
				<div class='dropdown'>
					<div class='login'>Witaj!</div>
					<div class='dropdown-content'>
						<div class='greetings'>Witaj!</div>
						<a href='user.php'>Otwórz profil</a>
						<a href='messages.php'>Wiadomości</a>
						<a href='logout.php'>Wyloguj</a>
					</div>
				</div>
				";
			}
			else{
				echo "
				<div class='dropdown'>
					<a href='login.php'><div class='login'>Zaloguj się</div></a>
				</div>";
			}
			
			?>
		</div>
		<br />
		<br />
		<div class="main">
            <?php
            $id=$_POST["id"];
            $sql = mysqli_query($dbconnect, "SELECT * FROM Zwierzaczki WHERE ID={$id}");
            while ($row = mysqli_fetch_array($sql)) {
				if($row["Aktywne"]==0){
					if($userid<0){
						header("Location: login.php");
					}
					echo "<h1 style='color:#FF0000;'>Post nieaktywny</h1><style>#sendMessage{display:none;}</style>";
				}
                echo 
                "
				<div class='head'>
					<div class='left'>
						<div class='imgcontainer'>
							<img class='image' src='data:image/jpeg;base64,".base64_encode( $row["image"] )."'>
						</div>
					</div>
					<div class='right'>
						<div class='title'>{$row['Tytul']}</div>
						<div class='race'>Rodzaj zwierzęcia: {$row['Typ']}</div>
						";
						if($row['Rasa']!=""){
							echo "<div class='race'>Rasa: {$row['Rasa']}</div>";
						}
						if($row['Plec']!=""){
							echo "<div class='race'>Płeć: {$row['Plec']}</div>";
						}
						echo "
						
						<form action='sendMessage.php' method='POST'>
							<input type='hidden' name='PostID' value='{$id}'>
							<input type='hidden' name='ReceiverID' value='{$row['UserID']}'>
							<input type='submit' class='button' id='sendMessage' value='Napisz wiadomość'>
						</form>
						<div class='phone'><b>Kontakt:</b><br />{$row['Numertelefonu']}</div>
						<br/>
						<div class='loc'><b>Lokalizacja:</b><br />{$row['Lokalizacja']}</div>
					</div>
				</div>
				<div class='foot'>
                <div class='description'>";
				if($row['Umaszczenie']!=""){
					echo "<b>Umaszczenie zwierzęcia:</b><br/>{$row['Umaszczenie']}<br/><br/>";
				}
				if($row['Cechy']!=""){
					echo "<b>Cechy zwierzęcia:</b><br/>{$row['Cechy']}<br/><br/>";
				}
				echo "<b>Opis:</b><br/>{$row['Opis']}</div>";
            }
			?>
			<div class="his">
			<b>Historia adopcji:</b><br/><br/>
			<?php
            $sql = mysqli_query($dbconnect, "SELECT * FROM History WHERE PostID={$id}");
			while ($row = mysqli_fetch_array($sql)) {
                echo 
                "
				<div class='history'>
					Chwilowa adopcja:<br/>
					Od {$row['StartDate']} <br/>do ";
				if($row['EndDate']!="" && $row['EndDate']!="0000-00-00"){
					echo "{$row['EndDate']}";
				}
				else{
					echo "Teraz";
				}
				
				echo"<br/>
					Uwagi: {$row['Notes']}
				</div>
                \n";
            }
            ?>
			</div>
		</div>
		</div>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
	</body>
</html>