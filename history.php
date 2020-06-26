<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Styles/index.css?v=1" />
		<link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		
		<link rel="icon" href="icon.png"/>
    	<title>PiesApp</title>
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
		if($userid<0){
			header('Location: login.php');
		}
		?>
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
			echo "<div id='PostID' style='display:none;'>{$_POST['id']}</div>";
			?>
		</div>
        <br/>
        <br/>
		<div class="main">
        <?php 
            $sql = mysqli_query($dbconnect, "SELECT * FROM History WHERE PostID={$_POST["id"]}");
			while ($row = mysqli_fetch_array($sql)) {
                echo 
                "
                <form action='updateHistory.php' method='POST'>
                    <input type='hidden' value='{$row['UpdateID']}' name='id'>
                    <div>
                        Chwilowa adopcja:<br/>
                        Od <input name='StartDate' type='date' value='{$row['StartDate']}'> do ";
                    if($row['EndDate']!=""){
                        echo "<input name='EndDate' type='date' value='{$row['EndDate']}'>";
                    }
                    else{
                        echo "<input name='EndDate' type='date'>";
                    }
                    
                    echo"<br/>
                        Uwagi:<br/>
                        <textarea name='Notes'>{$row['Notes']}</textarea>
                        <br/>
                        <input type='submit' value='Aktualizuj'>
                    </div>
                    <br/>
                </form>
                ";
            }
        ?>
        <button onClick="addNew()">Dodaj historię</button>
        <div id='new'>
        </div>
        <script>
            function addNew(){
                document.getElementById("new").innerHTML="<form action='addHistory.php' method='POST'><input type='hidden' name='PostID' value='"+document.getElementById("PostID").innerHTML+"'>"+"<div>Chwilowa adopcja:<br/> Od <input name='StartDate' type='date'> do <input name='EndDate' type='date'>"+"Uwagi:<br/><textarea name='Notes'>BRAK</textarea><br/><input type='submit' value='Dodaj'></form>";
            }
        </script>
		</div>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
    </body>
</html>