<?php
$host = "localhost"; // Adresse des Datenbankservers, meistens localhost
$user = "root"; // Ihr MySQL Benutzername
$pass = ""; // Ihr MySQL Passwort
$db = "acp"; // Name der Datenbank

$link = mysqli_connect($host, $user, $pass);
mysqli_select_db($link, $db);
if (mysqli_errno($link)) {
    echo "Datenbank nicht gefunden";
    die();
}
mysqli_query($link, "SET NAMES 'utf8'");
mysqli_query($link, "SET CHARACTER SET 'utf8'");

$salt = '$2y$10$' . bin2hex(random_bytes(11));
?>
