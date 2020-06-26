<!DOCTYPE html>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="Styles/addPost.css?v=3" />
        <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
		<link rel="icon" href="icon.png"/>
    	<title>PiesApp - Dodaj ogłoszenie</title>
		<script src="Scripts/jquery-3.5.1.min.js"></script>
		<script src="Scripts/jquery.inputmask.min.js"></script>
		<script src="https://cdn.tiny.cloud/1/xg1i4ch5lv7hhq2ralugomhiq5xmd0pta9j7tfvd4arr1qrz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
		<script>
		tinymce.init({ 
			selector:'#Opis',
			plugins: 'code lists',
			toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
		});
		function onLoad(){
			var uploadField = document.getElementById("img");
			$("#tel").inputmask("+99 999999999");
			$("#loc").inputmask("99-999, Aa{1,}");
			/*
			uploadField.onchange = function() {
				if(this.files[0].size > 307200){
				   alert("Plik jest za duży");
				   this.value = "";
				};
			};*/
		}
		
		</script>
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
			
			?>
		</div>
		<br />
		<br />
		<form action="savePost.php" method="post" class="main" enctype="multipart/form-data">
			
            <div class="header">Dodawanie ogłoszenia</div>
            <p>
				<div class="label">Tytuł ogłoszenia:</div>
                <input name="title" type="text" class="textbox" placeholder="np. Luna" autofocus autocomplete="off" required>
            </p>
            <p>
				<div class="label">Rodzaj zwierzęcia:</div>
                <input name="race" type="text" class="textbox" placeholder="np. Pies, kot, koń" autocomplete="off" required>
            </p>
			<p>
				<div class="label">Płeć</div>
				<select name="gender" required>
					<option value="Samiec">Samiec</option>
					<option value="Samica">Samica</option>
				</select>
            </p>
			<p>
				<div class="label">Rasa (Opcjonalne):</div>
                <input name="raceZ" type="text" class="textbox" placeholder="np. Maltańczyk" autocomplete="off">
            </p>
			<p>
				<div class="label">Umaszczenie (Opcjonalne):</div>
                <input name="skin" type="text" class="textbox" placeholder="np. Brązowe" autocomplete="off">
            </p>
			<p>
				<div class="label">Cechy szczególne (Opcjonalne):</div>
                <input name="features" type="text" class="textbox" placeholder="np. Plama na łapie" autocomplete="off">
            </p>
			<p>
				<div class="label">Opis sytuacji zwierzęcia:</div>
                <textarea id="Opis" name="desc"></textarea>
			</p>
			<?php 
			if($userid>0){
				$sql = mysqli_query($dbconnect, "SELECT * FROM Users WHERE ID LIKE '{$userid}'");
				while ($row = mysqli_fetch_array($sql)) {
					echo "
					<input name='UserID' type='hidden' value='{$userid}'>
					<div class='label'>Lokalizacja:</div>
						<input id='loc' name='loc' type='text' class='textbox' autocomplete='off' required value='{$row['Miasto']}'>
					</p>
					<div class='label'>Kontakt:</div>
						<input id='tel' name='phone' type='text' class='textbox' autocomplete='off' required value='{$row['NrTelefonu']}'>
					</p>";
				}
			}
			else{
				header('Location: login.php');
			}
			?>
            
			<input id="img" type="file" name="image"><br />
            <input class="button" type="submit" id="add">
        </form>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
	</body>
</html>