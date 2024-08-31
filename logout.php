<?php
include("database/pdo_connection.php");
setcookie("email", $user['email'], time() - 86400);
session_destroy();
header("location:home.php");


?>