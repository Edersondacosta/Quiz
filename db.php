<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "formulario";
$port = "3310";

$mysqli = new mysqli($host, $user, $pass, $db, $port);

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}
?>
