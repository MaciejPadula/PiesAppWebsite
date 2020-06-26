<?php
$servername = "localhost";
$username = "zset_piesapp";
$password = "tz9JvTUhO9";
$dbname = "zset_piesapp";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO History (PostID, StartDate, EndDate, Notes)
    VALUES ('".$_POST["PostID"]."','".$_POST["StartDate"]."','".$_POST["EndDate"]."','".$_POST["Notes"]."')";

    $conn->exec($sql);
    echo "New record created successfully";
    header('Location: user.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>