<?php
include("header.php");
include("pagetest.php");
include("bbc.inc.php");

echo "<h1>Bisherige Fragen</h1>";

$abfrage = "SELECT COUNT(id) AS anzahl FROM askme";
$ergebnis = mysqli_query($link, $abfrage);
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "<center>Bisher wurden <b>" . $row->anzahl . "</b> Fragen gestellt.<br>";
}

$abfrage = "SELECT COUNT(id) AS anzahl FROM askme WHERE antwort = '' OR antwort = 'Noch nicht beantwortet'";
$ergebnis = mysqli_query($link, $abfrage);
while ($row = mysqli_fetch_object($ergebnis)) {
    echo "Davon sind <b>" . $row->anzahl . "</b> Fragen noch unbeantwortet</center><br><br>";
}

//Seiten-Funktion
$itemsPerPage = 8;
$start = 0;
if (!empty($_GET['go'])) {
    $start = ($_GET['go'] - 1) * $itemsPerPage;
}
pagefunc($itemsPerPage, "askme", $link);

if ($start >= 0) {
    $abfrage = "SELECT * FROM askme ORDER BY time DESC LIMIT " . $start . ", " . $itemsPerPage;
} else {
    $abfrage = "SELECT * FROM askme ORDER BY time DESC LIMIT 0, " . $itemsPerPage;
}
$ergebnis = mysqli_query($link, $abfrage);
$i = 0;
echo "<center>";
while ($row = mysqli_fetch_object($ergebnis)) {
    $i++;
    echo "<table cellpadding='4' cellspacing='1' border='0' class='tableinborder' width='85%'>";
    echo "<tr>";
    echo "<th width='15%'>" . $i . "</th>";
    echo "<th width='38%'>" . $row->name . "</th>";
    echo "<th width='38%' align='right'>am " . date("d.m.Y", $row->time) . "</th>";
    echo "</tr><tr>";
    echo "<td><b>Frage:</b></td>";
    echo "<td colspan='2'>" . bbccode($row->frage, $link) . "</td>";
    echo "</tr><tr>";
    if ($row->webby != "") {
        echo "<td><b>" . $row->webby . ":</b></td>";
    } else {
        echo "<td></td>";
    }
    echo "<td colspan='2'>" . bbccode($row->antwort, $link) . "</td>";
    echo "</tr>";
    echo "</table><br>";

}
if ($i == 0) {
    echo "Bisher keine Frage vorhanden!<br>";
}

echo "</center><br><br>";
echo "<h1>Frage stellen</h1><CENTER>";

if (isset($_REQUEST["submit"])) {
    if (isset($_SESSION["captchax"]) && $_SESSION["captchax"] == $_POST["captcha"]) {
        unset($_SESSION["captchax"]);
        if (isset($_POST["name"]) && isset($_POST["message"])) {
            $eintrag = "INSERT INTO askme (name, frage, time, antwort, webby) 
				VALUES (
				'" . save($_POST['name'], $link) . "',
				'" . save($_POST['message'], $link) . "',
				'" . time() . "', 
				'Noch nicht beantwortet',
				''
				)";

            $eintragen = mysqli_query($link, $eintrag);
            if (mysqli_errno($link) == 0) {
                echo "<p class='ok'>Frage wurde erfolgreich eingetragen. 
					Vielen Dank! Deine Frage wird so schnell wie möglich beantwortet!</p><br />";
            } else { // Wenn MySQL Fehler..
                echo "<p class='fault'>Es ist leider ein Fehler aufgetreten " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>";
            }
        }
    } else {
        echo "<p class='fault'>Der Sicherheitscode ist falsch!</p><br>";
    }
}

echo "<script language='Javascript' src='bbcode.js'></script>";
echo "<form action='askme.php' method='POST' name='bbform'>
		<table class='commentinputs' width='85%'>
			<tr>
				<td colspan='2'><h2><img src='webicons/comment.png' border='0'> Ask-Formular</h2></td>
			</tr>
			<tr>
				<td width='32%'>Dein Name (optional):</td>
				<td><input type='text' name='name' value='" . (!empty($_POST['name']) ? $_POST['name'] : '') . "' class='textinput'></td>
			</tr>
			<tr>
				<td width='32%'>Deine Frage (*):</td>
				<td><div class='commenttext'>";
?>
<center><img src="bbc/bold.gif" alt="fettgedruckter Text" title="fettgedruckter Text" border="0"
             onclick="bbcode(document.bbform,'B','')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/italic.gif" alt="kursiver Text" title="kursiver Text" border="0"
         onclick="bbcode(document.bbform,'I','')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/underline.gif" alt="unterstrichener Text" title="unterstrichener Text" border="0"
         onclick="bbcode(document.bbform,'U','')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/center.gif" alt="zentrierter Text" title="zentrierter Text" border="0"
         onclick="bbcode(document.bbform,'CENTER','')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/url.gif" alt="Hyperlink einfügen" title="Hyperlink einfügen" border="0"
         onclick="namedlink(document.bbform,'URL')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/email.gif" alt="E-Mail-Adresse einfügen" title="E-Mail-Adresse einfügen" border="0"
         onclick="namedlink(document.bbform,'EMAIL')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/image.gif" alt="Bild einfügen" title="Bild einfügen" border="0"
         onclick="bbcode(document.bbform,'IMG','http://')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/quote.gif" alt="Zitat einfügen" title="Zitat einfügen" border="0"
         onclick="bbcode(document.bbform,'QUOTE','')" onmouseover="this.style.cursor='hand';"/>
    <img src="bbc/list.gif" alt="Liste erstellen" title="Liste erstellen" border="0" onclick="dolist(document.bbform)"
         onmouseover="this.style.cursor='hand';"/></center>
<?php
echo "<textarea rows=5 cols=30 name='message'>" . (!empty($_POST['message']) ? $_POST['message'] : '') . "</textarea><BR></div></td>
			</tr>
			<tr>           
				<td width='32%'>Captcha (*):</td>
				<td><img src='sicher.php' name='capt' alt=''> 
				<input type='text' name='captcha' size='5' value='' maxlength='5'> <input type='submit' name='submit' value='OK'></td>
			</tr>
		</table> 
		</form></CENTER><BR>";

include('footer.php');
?>
