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
    $upassword="";
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
    if($userid>0){
        $sql = "UPDATE Users SET Miasto='{$_POST["Miasto"]}' WHERE ID={$userid}";
        $sql2= "UPDATE Users SET NrTelefonu='{$_POST["NrTelefonu"]}' WHERE ID={$userid}";
        $sql3= "UPDATE Users SET Adres='{$_POST["Adres"]}' WHERE ID={$userid}";
        $sql4= "UPDATE Users SET Instytucja='{$_POST["Instytucja"]}' WHERE ID={$userid}";
        if (mysqli_query($dbconnect, $sql) && mysqli_query($dbconnect, $sql2)&& mysqli_query($dbconnect, $sql3)&& mysqli_query($dbconnect, $sql4)) {
            header('Location: user.php');
        } else {
            echo "Error updating record: " . mysqli_error($dbconnect);
        }
    }
    else{
        header('Location: login.php');
    }
?>