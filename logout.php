<?php
setcookie("login", "",time()+ (10 * 365 * 24 * 60 * 60));
setcookie("password","",time()+ (10 * 365 * 24 * 60 * 60));
header('Location: index.php');
?>