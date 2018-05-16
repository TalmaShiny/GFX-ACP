<?php
include("header.php");

if (isset($_POST["eintragen"])) { // Wenn Formular abgeschickt wurde....
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["passwort1"]) && $_POST["passwort1"] == $_POST["passwort2"]) {
        if (preg_match("/^[A-Za-z0-9 ]+$/", $_POST["name"])) {
            if (empty($_POST["email"])
                || (!empty($_POST["email"]) && preg_match("/^[_a-z0-9-.]*@[_a-z0-9-.]*\.[a-z]{2,4}$/i", $_POST["email"]))) {
                $eintragen = mysqli_query($link, "INSERT INTO benutzer (name, passwort, email, hp, tag, monat, jahr, bild, benutzertext, since, gruppe, refresh) VALUES (
					'" . $_POST["name"] . "',
					'" . crypt($_POST["passwort1"], $salt) . "',
					'" . $_REQUEST["email"] . "',
					'',
					'0',
					'0',
					'0',
					'',
					'',
					'" . time() . "',
					'1',
					'0'
					)");
                if (mysqli_errno($link) == 0) {
                    $_SESSION["acp"] = mysqli_insert_id($link);// Loggt einen ein!
                    echo "<p class='ok'>Gratuliere! Du bist jetzt registriert und eingeloggt.<br> <a href=memberarea.php>Weiter zur Memberarea</a></p>";
                } else {
                    echo "<p class='fault'>Fehler " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
                }
            } else {
                echo "<p class='fault'>Die Email-Adresse ist ungültig!</p>";
            }
        } else {
            echo "<p class='fault'>Der Name ist ungültig! Bitte nur Buchstaben und Ziffern verwenden</p>";
        }
    } else { // Wenn nicht alle Felder ausgefüllt
        echo "<p class='fault'>Bitte alle Felder ausfüllen!</p>";
    }
} else { // Wenn nicht abgeschickt, dann zeige Formular
    echo "<h1>Registration</h1>";
    echo "<form action='registrierung.php' method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<td><b>Name:</b></td>";
    echo "<td><input type='text' name='name'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><b>E-Mail:</b></td>";
    echo "<td><input type='text' name='email'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><b>Passwort:</b></td>";
    echo "<td><input type='password' name='passwort1'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><b>Passwort Wiederholung:</b></td>";
    echo "<td><input type='password' name='passwort2'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td><input type='submit' value='Registrieren' name='eintragen'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
}
include("footer.php");
?>
