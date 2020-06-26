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
    $receiver=0;
    $sql2 = mysqli_query($dbconnect, "SELECT * FROM Users WHERE Login LIKE '{$_POST['Receiver']}'");
    while ($row2 = mysqli_fetch_array($sql2)) {
        $receiver=$row2['ID'];
    }

    $sql = "INSERT INTO Messages (SenderID, ReceiverID, PostID, Message, isRead)
    VALUES ('".$_POST["SenderID"]."','{$receiver}','".$_POST["PostID"]."','".$_POST["message"]."',0)";

    $conn->exec($sql);
    echo "New record created successfully";
    header('Location: messages.php');
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>