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
        $id = "DELETE FROM Zwierzaczki WHERE ID={$_POST["id"]}";
        if (mysqli_query($dbconnect, $id)) {
            header('Location: index.php');
        } else {
            echo "Error updating record: " . mysqli_error($dbconnect);
        }
    }
    else{
        header('Location: login.php');
    }
    
?>