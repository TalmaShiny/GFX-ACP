<?php
include("header.php");
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    echo "<h1>Eingeloggt</h1>
		<center><b>Hallo und Herzlich Willkommen in deinem ACP!</b><br>
		Was wirst du denn heute tun? Wähle links aus der Navi doch einfach eine Option. :)<br></center>";
} else {
    echo "<p class='fault'>Du hast keinen Zutritt!</p>";
}
include("footer.php");
?>
