<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
        <link rel="stylesheet" type="text/css" href="Styles/login.css?v=1" />
		<link rel="icon" href="icon.png"/>
    	<title>PiesApp</title>
		<script src="Scripts/jquery-3.5.1.min.js"></script>
		<script src="Scripts/jquery.inputmask.min.js"></script>
		<script type="text/javascript">
		
		var bol=[false,false,false,false];

		function regex(sender,warunek,num){
			check_Pass();
			const reg=warunek;
			bol[num]=reg.test(sender.value);
			if(reg.test(sender.value)){
				sender.style.backgroundColor="#00FF00";
			}
			else{
				
				sender.style.backgroundColor="#FF0000";
			}
			dis();
		}
		function dis(){
			var x=true;
			for(i=0;i<4;i++){
				if(!bol[i]) x=false;
			}
			if(x) document.getElementById('send').disabled =false;
			else document.getElementById('send').disabled =true;
		}
		function onLoad(){
			document.getElementById('send').disabled=true;
			$(":input").inputmask();
		}
		
		function check_Pass(){
			if(document.getElementById('repeatpassword').value==document.getElementById('password').value && document.getElementById('repeatpassword').value!=''){
				document.getElementById('repeatpassword').style.backgroundColor="#00FF00";
				bol[3]=true;
			}
			else{
				document.getElementById('repeatpassword').style.backgroundColor="#FF0000";
				bol[3]=false;
			}
			dis();
		}
		</script>
	</head>
	<body onLoad="onLoad()">
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
			
		</div>
		<form action="addUser.php" method="post" class="main" id="log">
			<h3>Zarejetruj się!</h3>
			<?php
			if($_GET["error"]==1){
				echo "<p style='color:#FF0000;'>Podany login już istnieje</p>";
			}
			?>
			<p>Login<br />
				<input class="textbox" name="Login" type='text' onInput='regex(this,/^[A-Za-z0-9!@#\$%\^\&*\)\(+=._-]{5,15}$/,0)'>
			</p>
			<p>Nazwa instytucji(Opcjonalne)<br />
				<input class="textbox" name="Instytucja" type='text'>
			</p>
			<p>Telefon<br />
				<input data-inputmask="'mask': '+99 999999999'" class="textbox" name="Telefon" type='text' onInput='regex(this,/^[+][0-9]{2}[ ][0-9]{9}$/,1)' placeholder="+48 123456789">
			</p>
			<p>Miasto, kod pocztowy<br />
				<input data-inputmask="'mask': '99-999, Aa{1,}'" class="textbox" name="Miasto" type='text' onInput='regex(this,/^[0-9]{2}-[0-9]{3}[,][ ][A-Z]{1}[a-zżźćńółęąś]{2,}$/,2)' placeholder="00-000, Miasto">
			</p>
			<p>Adres(Opcjonalne)<br />
				<input class="textbox" name="Adres" type='text'>
			</p>
			<p>Hasło<br />
			<input class="textbox" name="Haslo" id='password' type='password' onInput='regex(this,/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,3),check_Pass()'>
			</p>
			<p>Powtórz hasło<br />
				<input class="textbox" id='repeatpassword' type='password' onInput='check_Pass()'>
			</p>
			<input class="button" id='send' type='submit' value="Zarejestruj się">
		</form>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
	</body>
</html>