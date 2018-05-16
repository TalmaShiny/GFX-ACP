<?php // NAVI WENN EINGELOGGT
echo "<h1>Main</h1>";
echo "<a href='index.php' class='navi'>Startseite</a>";
echo "<a href='team.php' class='navi'>Team</a>";
echo "<a href='credits.php' class='navi'>Credits</a>";

echo "<a href='affis.php' class='navi'>Affilliates</a>";
echo "<a href='becomeaffi.php' class='navi'>Affiliate werden</a>";

echo "<a href='askme.php' class='navi'>Ask & Answer</a>";
echo "<a href='updateplan.php' class='navi'>Updateplan</a>";
echo "<a href='statistik.php' class='navi'>Statistik</a>"; /* Falls Modul nicht installiert bitte Zeile löschen! */
echo "<a href='forum_index.php' class='navi'>Forum</a>";

echo "<h1>Interaktiv</h1>";
echo "<a href='reviews.php' class='navi'>Reviews</a>";
echo "<a href='tutorials.php' class='navi'>Tutorials</a>";
echo "<a href='downloads.php' class='navi'>Downloads</a>";

echo "<h1>Graphics</h1>";
echo "<a href='icons.php' class='navi'>Icons</a>";
echo "<a href='iconbases.php' class='navi'>Iconbases</a>";
echo "<a href='icontextures.php' class='navi'>Icontexture</a>";
echo "<br>";

echo "<a href='blends.php' class='navi'>Blends</a>";
echo "<a href='headers.php' class='navi'>Headers</a>";
echo "<a href='sigs.php' class='navi'>Signatures</a>";
echo "<a href='wallpapers.php' class='navi'>Wallpapers</a>";
echo "<a href='brushes.php' class='navi'>Brushes</a>";
echo "<a href='psds.php' class='navi'>PSDs</a>";
echo "<a href='designs.php' class='navi'>Designs</a>";
echo "<a href='textures.php' class='navi'>Textures</a>";
echo "<a href='materials.php' class='navi'>Materials</a>";

if (isset($_SESSION["acp"])) {
    $abfrage = "SELECT max(id) AS max FROM navisparten";
    $ergebnis = mysqli_query($link, $abfrage);
    $zahl = mysqli_fetch_object($ergebnis);
    $max = $zahl->max;

    for ($i = 1; $i <= $max; $i++) {
        $abfrage = "SELECT * FROM navisparten WHERE id='" . $i . "'";
        $ergebnis = mysqli_query($link, $abfrage);
        $row = mysqli_fetch_object($ergebnis);
        echo "<h1>" . $i . ": " . $row->Spartenbezeichnung . "</h1>";

        if ($i == 1) {
            if (wert("benutzer WHERE id='" . $_SESSION["acp"] . "'", "gruppe", $link) == 1) {
                $abfrage = "SELECT * FROM navilinks WHERE sparte='" . $i . "' ORDER BY name ASC";
                $ergebnis = mysqli_query($link, $abfrage);
                while ($row = mysqli_fetch_object($ergebnis)) {
                    echo "<a href='" . $row->datei . "' class='navi'>" . $row->name . "</a>";
                }
            }
        } else {
            $abfrage = "SELECT * FROM navilinks WHERE sparte='" . $i . "' ORDER BY name ASC";
            $ergebnis = mysqli_query($link, $abfrage);
            while ($row = mysqli_fetch_object($ergebnis)) {
                echo "<a href='" . $row->datei . "' class='navi'>" . $row->name . "</a>";
            }
        }
    }
    echo "<br><a href='logout.php' class='kommentare'>Logout</a><br><br>";

} else {
    echo "<h1>Login</h1>";
    echo "<form action='login.php?action=login' method='post'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Name:</td>";
    echo "<td><input type='text' name='name'></td>";
    echo "</tr><tr>";
    echo "<td>Passwort:</td>";
    echo "<td><input type='password' name='passwort'></td>";
    echo "</tr><tr>";
    echo "<td></td>";
    echo "<td><input type='submit' value='Login' name='einloggen'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
}
?>
