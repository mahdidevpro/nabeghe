<?php

include("database/pdo_connection.php");

$getId=$_GET['id'];


$DELETE=$coon->prepare('DELETE FROM store  WHERE id=?');

$DELETE->bindValue(1,$getId);
$DELETE->execute();

header("location:cart");

?>