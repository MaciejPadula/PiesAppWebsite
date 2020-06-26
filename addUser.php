<?php
$servername = "localhost";
$username = "zset_piesapp";
$password = "tz9JvTUhO9";
$dbname = "zset_piesapp";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbconnect=mysqli_connect($servername,$username,$password,$dbname);
	
	$sql = mysqli_query($dbconnect, "SELECT * FROM Users");
	$bool = 1;
	while ($row = mysqli_fetch_array($sql)) {
		if($row["Login"]==$_POST["Login"]){
			$bool = 0;
		}   
	}
    if($bool==1){
		$hashPassword = password_hash($_POST["Haslo"], PASSWORD_DEFAULT);
		
		$sql = "INSERT INTO Users (Login, Haslo, NrTelefonu, Adres, Instytucja, Miasto)
		VALUES ('".$_POST["Login"]."','".$hashPassword."','".$_POST["Telefon"]."','".$_POST["Adres"]."','".$_POST["Instytucja"]."','".$_POST["Miasto"]."')";
		// use exec() because no results are returned
		// use exec() because no results are returned
		$conn->exec($sql);
		echo "New record created successfully";
		header('Location: logout.php');
	}
	else{
		header('Location: register.php?error=1');
    }
}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>