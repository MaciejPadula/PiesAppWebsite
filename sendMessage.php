<!DOCTYPE html>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="Styles/addPost.css?v=1" />
        <link rel="stylesheet" type="text/css" href="Styles/general.css?v=4" />
		<link rel="icon" href="icon.png"/>
    	<title>PiesApp</title>
		<script src="https://cdn.tiny.cloud/1/xg1i4ch5lv7hhq2ralugomhiq5xmd0pta9j7tfvd4arr1qrz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
		<script>tinymce.init({ 
			selector:'#message',
			plugins: 'code lists',
			toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
		});
		</script>
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
        <form action="saveMessage.php" method="post" class="main" enctype="multipart/form-data">
            
			<?php 
			if($userid>0){
                echo "<input name='SenderID' type='hidden' value='{$userid}'><div>{$login}</div>";
                if($_POST['ReceiverID']!=""){
                    $receiver="";
                    $sql2 = mysqli_query($dbconnect, "SELECT * FROM Users WHERE ID LIKE '{$_POST['ReceiverID']}'");
                    while ($row2 = mysqli_fetch_array($sql2)) {
                        $receiver=$row2['Login'];
                    }
                    echo "
                    <p>
                        <input type='text' name='Receiver' value={$receiver}>
                    </p>";
                }
                else{
                    echo "
                    <p>
                        <input type='text' name='Receiver'>
                    </p>";
                }
                if($_POST['PostID']!=""){
                    echo "
                    <p>
                        <input type='hidden' name='PostID' value='{$_POST['PostID']}'>
                    </p>";
                }
                if($_POST['message']!=""){
                    echo "
                    <p>
                        <textarea id='message' name='message'><br/>Odpowiedź na:<br/>{$_POST['message']}</textarea>
                    </p>";
                }
                else{
                    echo "
                    <p>
                        <textarea id='message' name='message'></textarea>
                    </p>";
                }
			}
			else{
				header('Location: login.php?error=2');
			}
			?>
            <input type="submit" id="add">
        </form>
		<div class="footer">Copyright &copy; Maciej Padula, Karol Więckowiak 2020</div>
	</body>
</html>