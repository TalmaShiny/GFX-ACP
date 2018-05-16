<?php
include("header.php"); // Header PHP einbinden

if (isset($_POST["einloggen"])) {// Wenn Formular abgeschickt
    if ($_POST["passwort"] != "" && $_POST["name"] != "") {
        $select = "SELECT id, passwort FROM benutzer WHERE name = '" . save($_POST["name"], $link) . "' LIMIT 1";
        $query = mysqli_query($link, $select);
        $row = mysqli_fetch_object($query);
        if (hash_equals($row->passwort, crypt($_POST["passwort"], $row->passwort))) {
            $_SESSION["acp"] = $row->id; // Loggt einen ein!

            $eintragen = mysqli_query($link, "INSERT INTO benutzer_login (name, ip, timestamp, status) VALUES (
				'" . save(strip_tags($_POST["name"]), $link) . "', 
				'" . getenv("REMOTE_ADDR") . "', 
				'" . time() . "', 
				'erfolgreich')"); // Eintrag in Login!

            echo "<meta http-equiv='refresh' content='0; URL=memberarea.php'>"; // Weiterleitung zur Memberarea
        } else { // Wenn falsch eingeloggt
            echo "<h1>Sorry</h1> <p class='fault'>Der Login schlug fehl.</p>";
            $eintragen2 = mysqli_query($link, "INSERT INTO benutzer_login (name, ip, timestamp, status) VALUES (
				'" . save(strip_tags($_POST["name"]), $link) . "', 
				'" . getenv("REMOTE_ADDR") . "', 
				'" . time() . "', 
				'gescheitert')"); // Eintrag in Login!
        }
    }
} else { /* Wenn noch nicht abgeschickt, dann zeige Formular*/
    echo "<h1>Login</h1>";
    echo "<form method='post'>";
    echo "<table width=90%>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='name'></td>";
    echo "</tr><tr>";
    echo "<td>PW:</td>";
    echo "<td><input type='password' name='passwort'></td>";
    echo "</tr><tr>";
    echo "<td></td>";
    echo "<td><input type='submit' name='einloggen' value='Login'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
}
include("footer.php"); //Footer einbinden
?>
