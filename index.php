<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Styles/index.css?v=1" />
		<link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		
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
		
		<?php
		$sql ="";
		if($_POST["fraza"]!=""){
			$sql = mysqli_query($dbconnect, "SELECT * FROM Zwierzaczki WHERE Aktywne=1 and (Tytul LIKE '%{$_POST["fraza"]}%' or Typ LIKE '%{$_POST["fraza"]}%')  ORDER BY Tytul ASC ");
			echo "<p><b>Wyniki wyszukiwania:</b><br />{$_POST["fraza"]}</p>";
		}
		else{
			$sql = mysqli_query($dbconnect, "SELECT * FROM Zwierzaczki WHERE Aktywne=1 ORDER BY Tytul ASC");
		}
		echo "<div class='main'>";
		
		while ($row = mysqli_fetch_array($sql)) {
			echo
			"
			<div class='ogloszenie'>
				<div class='imgcontainer'>
					<img class='img' src='data:image/jpeg;base64,".base64_encode( $row["image"] )."' alt='Nie ma obrazka'>
				</div>
				<div class='title'>{$row['Tytul']}</div>
				<div class='race'>{$row['Typ']}</div>
				<form action='viewPost.php' method='POST'>
					<input type='hidden' value='{$row['ID']}' name='id' />
					<input id='ViewPost' class='buttonSubmit' type='submit' value='Zobacz'>
				</form>
			</div>
			\n";
		}
		?>
		</div>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
	</body>
</html>