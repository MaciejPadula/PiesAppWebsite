<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
        <link rel="stylesheet" type="text/css" href="Styles/index.css?v=1" />
        <link rel="stylesheet" type="text/css" href="Styles/user.css?v=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        
        <link rel="icon" href="icon.png"/>
        <title>PiesApp</title>
		<script src="Scripts/jquery-3.5.1.min.js"></script>
		<script src="Scripts/jquery.inputmask.min.js"></script>
		<script>
		function onLoad(){
			$("#tel").inputmask("+99 999999999");
			$("#loc").inputmask("99-999, Aa{1,}");
		}
		</script>
    </head>
    <body onLoad="onLoad()">
        <?php
            $login="";
            $upassword="";
            if($_POST['Login']!="" && $_POST['Haslo']!=""){
                setcookie("login", $_POST['Login'],time()+ (10 * 365 * 24 * 60 * 60));
                setcookie("password", $_POST['Haslo'],time()+ (10 * 365 * 24 * 60 * 60));
                $login=$_POST['Login'];
                $upassword=$_POST['Haslo'];
            }
            else if($_COOKIE['login']!="" && $_COOKIE['password']!=""){
                $login=$_COOKIE['login'];
                $upassword=$_COOKIE['password'];
            }
            if($login=="" && $upassword==""){
               header('Location: login.php');
            }
            
            $hostname = "localhost";
            $username = "zset_piesapp";
            $password = "tz9JvTUhO9";
            $db = "zset_piesapp";

            $dbconnect=mysqli_connect($hostname,$username,$password,$db);

            if ($dbconnect->connect_error) {
            die("Database connection failed: " . $dbconnect->connect_error);
            }

            $userid=-21;
            if($login!="" && $upassword!=""){
                $sql = mysqli_query($dbconnect, "SELECT * FROM Users WHERE Login='{$login}'");
                while ($row = mysqli_fetch_array($sql)) {
                    if(password_verify($upassword, $row['Haslo'])){
						$userid=$row['ID'];
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
                    $sql = mysqli_query($dbconnect, "SELECT * FROM Users WHERE ID LIKE '{$userid}'");
                    while ($row = mysqli_fetch_array($sql)) {
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
				
                        
                        </div>
                        <br />
                        <br />
						
                        <p>
                            <h2>Witaj {$row['Login']}!</h2><div class='label'>Oto panel konfiguracji twojego konta:</div>
                        </p>
                        <form action='updateAccount.php' method='POST'>
                            <table>
                                <tr>
                                    <td class='label'>Instytucja:</td>
                                    <td><input class='textbox' name='Instytucja' minlength='9' type='text' value='{$row['Instytucja']}'></td>
                                </tr>
                                <tr>
                                    <td class='label'>Adres:</td>
                                    <td><input class='textbox' name='Adres' minlength='9' type='text' value='{$row['Adres']}'></td>
                                </tr>
                                <tr>
                                    <td class='label'>Numer telefonu:</td>
                                    <td><input id='tel' class='textbox' name='NrTelefonu' minlength='9' type='text' value='{$row['NrTelefonu']}'></td>
                                </tr>
                                <tr>
                                    <td class='label'>Miasto:</td>
                                    <td><input id='loc' class='textbox' name='Miasto' type='text' value='{$row['Miasto']}'></td>
                                </tr>
                            </table>
                            <input class='button' type='submit' value='Zaktualizuj informacje konta'>
                        </form>
                        <form action='addPost.php' method='POST'>
                            <input class='button' type='submit' value='Dodaj post'>
                        </form>
                        <br />
                        <div class='header'>Posty użytkownika:</div>
						<div class='main'>
                        ";
                    }
                    
                    $sql = mysqli_query($dbconnect, "SELECT * FROM Zwierzaczki WHERE UserID LIKE '{$userid}' ORDER BY Tytul ASC ");
                
                    while ($row = mysqli_fetch_array($sql)) {
                        echo
                        "
                        <div class='ogloszenie' "; 
						if($row['Aktywne']==0){
							echo "style='background-color:#ABABAB;'";
						}
						echo ">
                            <div class='imgcontainer'>
                                <img class='img' src='data:image/jpeg;base64,".base64_encode( $row["image"] )."' alt='Nie ma obrazka'>
                            </div>
							<div class='title'
							";
                            if($row['Aktywne']==0){
								echo " style='color:#FFFFFF;'";
							}
							echo "
							>{$row['Tytul']}</div>
                            <div class='race'>{$row['Typ']}</div>
                            <div class='dropdown' style='width:100%;margin:0;height:auto;'>
								<div class='dropdown-content' style='width:100%;margin:0;'>
								<form name='view-form' action='contract.php' method='POST' target='_blank'>
                                    <input type='hidden' value='{$row['ID']}' name='id' />
                                    <input id='generateContract' class='buttonSubmit' type='submit' value='Generuj umowę'>
                                </form>
                                <form name='view-form' action='edit.php' method='POST'>
                                    <input type='hidden' value='{$row['ID']}' name='id' />
                                    <input class='buttonSubmit' type='submit' value='Edytuj'>
                                </form>
								
								<form name='view-form' action='history.php' method='POST'>
                                    <input type='hidden' value='{$row['ID']}' name='id' />
                                    <input class='buttonSubmit' type='submit' value='Edytuj historie'>
                                </form>
								<form name='view-form' action='viewPost.php' method='POST' target='_blank'>
                                    <input type='hidden' value='{$row['ID']}' name='id' />
                                    <input class='buttonSubmit' type='submit' value='Zobacz post'>
                                </form>
								<form name='view-form' action='status.php' method='POST'>
								
								<input type='hidden' value='{$row['ID']}' name='id' />
						";
						if($row['Aktywne']==1){
							echo "
								<input type='hidden' value='0' name='status' />
								<input class='buttonSubmit' type='submit' value='Zakończ'>
							";
						}
						else{
							echo "
								<input type='hidden' value='1' name='status' />
								<input class='buttonSubmit' type='submit' value='Wznów'>
							";
						}
						echo "</form>
								</div>
								<div class='buttonSubmit' style='padding:2%;position:absolute;bottom:0;left:0;right:0;'>Opcje</div>
							</div>
							</div>";
                    }
                }
                else{
                    header('Location: login.php');
                }
            ?>
			
        </div>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
    </body>
</html>