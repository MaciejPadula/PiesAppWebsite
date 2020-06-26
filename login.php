<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
	<link rel="stylesheet" type="text/css" href="Styles/login.css?v=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    
    <link rel="icon" href="icon.png"/>
    <title>PiesApp</title>
    </head>
    <body>
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
			<div class='dropdown'>
				<a href='login.php'><div class='login'>Zaloguj się</div></a>
			</div>
		</div>
		<br />
		<br />
		<form action="user.php" method="POST" class="main" id="log">
			<?php
			if($_GET["error"]==2){
				echo "<p style='color:#FF0000;'>Aby napisać wiadomość musisz się zalogować</p>";
			}
			?>
			<div class="label">Login:</div>
			<input class="textbox" type="text" name="Login">
			<div class="label">Hasło:</div>
			<input class="textbox" type="password" name="Haslo">
			<br />
			<br />
			<input class="button" type="submit" value="Zaloguj się">
			<br />
			<a href="register.php" style="color:#0000FF;text-decoration:underline;">Nie masz jeszcze konta? Zarejestruj się!</a>
		</form>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
    </body>
</html>