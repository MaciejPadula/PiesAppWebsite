<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
        <link rel="stylesheet" type="text/css" href="Styles/messages.css?v=6" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        
        <link rel="icon" href="icon.png"/>
        <title>PiesApp</title>
        <script>
            function showReceived(){
                document.getElementById("sentMessages").style.display = "none"; 
                document.getElementById("receivedMessages").style.display = "block";
            }
            function showSent(){
                document.getElementById("sentMessages").style.display = "block";
                document.getElementById("receivedMessages").style.display = "none"; 
            }
        </script>
    </head>
    <body>
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
                    </div>";
                    }
                    echo "
                    <div class='main'>
					<div style='text-align:center;width:100%;'>
                    <button onClick='showSent()' class='button'>Wysłane</button>
                    <button onClick='showReceived()' class='button'>Odebrane</button>
					</div>
                    <div id='sentMessages'>
                    ";
                    ///SENT
                    $sql = mysqli_query($dbconnect, "SELECT * FROM Messages WHERE SenderID LIKE '{$userid}' ORDER BY MessageID DESC");
                    while ($row = mysqli_fetch_array($sql)) {
                        $receiver="";
                        $sql2 = mysqli_query($dbconnect, "SELECT * FROM Users WHERE ID LIKE '{$row['ReceiverID']}'");
                        while ($row2 = mysqli_fetch_array($sql2)) {
                            $receiver=$row2['Login'];
                        }
                        if($row['isRead']){
                            echo "
                            <div class='message'>";
                        }
                        else{
                            echo "
                            <div class='message' id='unread'>";
						}
						echo "
							<div class='user'>Nadawca: {$login}</div>
							<div class='user'>Odbiorca: {$receiver}</div>
							<div class='text'>{$row['Message']}</div>
							<form action='viewPost.php' method='POST' target='_blank'>
                                <input type='hidden' name='id' value='{$row['PostID']}'>
                                <input type='submit' class='button' value='Zobacz post'>
                            </form>
						</div>";   
                    }
                    echo "</div>";

                    echo "<div id='receivedMessages'>";
                    ///RECEIVED
                    $sql = mysqli_query($dbconnect, "SELECT * FROM Messages WHERE ReceiverID LIKE '{$userid}' ORDER BY MessageID DESC");
                    
                    while ($row = mysqli_fetch_array($sql)) {
                        $setRead = "UPDATE Messages SET isRead=1 WHERE ReceiverID LIKE '{$userid}'";
                        
                        $sender="";
                        $sql2 = mysqli_query($dbconnect, "SELECT * FROM Users WHERE ID LIKE '{$row['SenderID']}'");
                        while ($row2 = mysqli_fetch_array($sql2)) {
                            $sender=$row2['Login'];
                        }
						
                        echo "
                        <div class='message'>";
						if(!$row['isRead']){echo"<b>";}
						echo"
                            <div class='user'>Nadawca: {$sender}</div>
                            <div class='user'>Odbiorca: {$login}</div>
                            <div class='text' style='float:left'>{$row['Message']}</div>
						";
						if(!$row['isRead']){echo"</b>";}
						echo"
                            <form action='sendMessage.php' method='POST'>
                                <input type='hidden' name='message' value='{$row['Message']}'>
                                <input type='hidden' name='PostID' value='{$row['PostID']}'>
                                <input type='hidden' name='ReceiverID' value='{$row['SenderID']}'>
                                <input type='submit' class='button' style='float:left;' value='Odpowiedz'>
                            </form>
							<form action='viewPost.php' method='POST' target='_blank'>
                                <input type='hidden' name='id' value='{$row['PostID']}'>
                                <input type='submit' class='button' value='Zobacz post'>
                            </form>
                        </div>"; 
						mysqli_query($dbconnect, $setRead);
						
                    }
                    echo "</div>";
                }
                else{
                    header('Location: login.php');
                }
            ?>
            </div>
			<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
    </body>
</html>