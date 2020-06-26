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
        $title = "UPDATE Zwierzaczki SET Tytul='{$_POST["title"]}' WHERE ID={$_POST["ID"]}";
        $race = "UPDATE Zwierzaczki SET Typ='{$_POST["race"]}' WHERE ID={$_POST["ID"]}";
        $gender = "UPDATE Zwierzaczki SET Plec='{$_POST["gender"]}' WHERE ID={$_POST["ID"]}";
        $raceZ = "UPDATE Zwierzaczki SET Rasa='{$_POST["raceZ"]}' WHERE ID={$_POST["ID"]}";
        $skin = "UPDATE Zwierzaczki SET Umaszczenie='{$_POST["skin"]}' WHERE ID={$_POST["ID"]}";
        $features = "UPDATE Zwierzaczki SET Cechy='{$_POST["features"]}' WHERE ID={$_POST["ID"]}";
		$desc = "UPDATE Zwierzaczki SET Opis='{$_POST["desc"]}' WHERE ID={$_POST["ID"]}";
        $loc = "UPDATE Zwierzaczki SET Lokalizacja='{$_POST["loc"]}' WHERE ID={$_POST["ID"]}";
        $phone = "UPDATE Zwierzaczki SET Numertelefonu='{$_POST["phone"]}' WHERE ID={$_POST["ID"]}";

        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        echo $desc;
		echo "<br/>";
        if (mysqli_query($dbconnect, $title) && mysqli_query($dbconnect, $race) && mysqli_query($dbconnect, $gender)&& mysqli_query($dbconnect, $raceZ)&& mysqli_query($dbconnect, $skin)&& mysqli_query($dbconnect, $features)&& mysqli_query($dbconnect, $desc) && mysqli_query($dbconnect, $loc) && mysqli_query($dbconnect, $phone)) {
            if($imgContent!=""){
                $img = "UPDATE Zwierzaczki SET image='$imgContent' WHERE ID={$_POST["ID"]}";
                mysqli_query($dbconnect, $img);
            }
            header('Location: index.php');
        } else {
            echo "Error updating record: " . mysqli_error($dbconnect);
        }
    }
    else{
        header('Location: login.php');
    }
    
?>