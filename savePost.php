<?php
$servername = "localhost";
$username = "zset_piesapp";
$password = "tz9JvTUhO9";
$dbname = "zset_piesapp";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));
    
    $sql = "INSERT INTO Zwierzaczki (Tytul, Typ, Plec, Rasa, Umaszczenie, Cechy, Opis, Lokalizacja, Numertelefonu, image, UserID, Aktywne)
    VALUES ('".$_POST["title"]."','".$_POST["race"]."','".$_POST["gender"]."','".$_POST["raceZ"]."','".$_POST["skin"]."','".$_POST["features"]."','".$_POST["desc"]."','".$_POST["loc"]."','".$_POST["phone"]."','$imgContent','".$_POST["UserID"]."',1)";
    // use exec() because no results are returned
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
    header('Location: index.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>