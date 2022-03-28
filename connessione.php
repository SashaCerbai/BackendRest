<?php
$host="localhost";
$user="root";
$pass="my-secret-pw";
$db="create_employee";

$mysqli= new mysqli($host, $user, $pass, $db)
or die ("<br>Connessione non riuscita" . $mysqli->connect_error . " " .$mysqli->connect_errno)
?>