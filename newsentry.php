<?php
include('header.php');
include('pagetest.php');
include('bbc.inc.php');

// NEWSEINTRAG AUSGEBEN
if (is_numeric($_REQUEST["id"])) {
    $abfrage = "SELECT * FROM news WHERE id='" . $_REQUEST["id"] . "'";
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        echo "<div class='gfx'>";
        echo "<h1>" . $row->title . "</h1>";
        echo "<table width='100%'>";
        echo "<tr>";
        echo "<td>";
        echo "<p class='datum'><i>Von <b>" . $row->autor . "</b> - am " . date("d.m.Y", $row->time) . " 
						um " . date("H:i", $row->time) . " Uhr</i></p>";
        echo bbccode($row->text, $link) . "<br>";
        echo "<br>";
        if ($row->updates != "") {
            echo "<div class='updates'><h2>Updates:</h2>" . bbccode($row->updates, $link) . "</div>";
        }
        echo "</tr>";
        echo "</table><br>";

    }

    //KOMMENTARE HIER
    echo "<br><h1>Bisherige Kommentare</h1><center>";
    echo "Es werden immer <b>8</b> pro Seite angezeigt!<br><br>";

    $itemsPerPage = 8;
    $start = 0;
    if (!empty($_GET['go'])) {
        $start = ($_GET['go'] - 1) * $itemsPerPage;
    }
    pagecommi($itemsPerPage, "news_kommentare", $_REQUEST['id'], $link);

    if ($start >= 0) {
        $abfrage = "SELECT * FROM news_kommentare WHERE news_id='" . $_REQUEST["id"] . "' ORDER BY id DESC LIMIT " . $start . ", " . $itemsPerPage;
    } else {
        $abfrage = "SELECT * FROM news_kommentare WHERE news_id='" . $_REQUEST["id"] . "' ORDER BY id DESC LIMIT 0, " . $itemsPerPage;
    }

    $ergebnis2 = mysqli_query($link, $abfrage);
    $i = 0;
    while ($row = mysqli_fetch_object($ergebnis2)) {
        echo "<table width='80%' cellpadding='4' cellspacing='1' border='0' class='tableinborder'>";
        echo "<tr>";
        echo "<th width='40%' align='left'><b>" . $row->name . "</b></th>";
        echo "<th width='15%' align='center'>";
        if ($row->email != "") {
            echo "<a href=\"mailto:" . $row->email . "\"><img src='webicons/mail.png' border='0'></a> ";
        }
        if ($row->hp != "") {
            echo "<a href=\"" . $row->hp . "\" target=\"_blank\"><img src='webicons/website.png' border='0'></a>";
        }
        echo "</th>";
        echo "<th align='right'>";
        echo date("d.m.Y", $row->time) . " um " . date("H:i", $row->time) . " Uhr";
        echo "</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='3' align='left'>" . bbccode($row->text, $link) . "</td>";
        echo "</tr>";
        echo "</table><br>";
        $i++;
    }
    if ($i == 0) {
        echo "Bisher keine Kommentare<br><BR>";
    }
}

if (isset($_POST['submit2'])) {
    if (is_numeric($_REQUEST["id"])) {
        if (isset($_SESSION["captchax"]) && $_SESSION["captchax"] == $_POST["captcha"]) {
            unset($_SESSION["captchax"]);
            if (!empty($_POST["name"]) && !empty($_POST["message"])) {
                if (preg_match("/^[A-Za-z0-9 ]+$/", $_POST["name"])) {
                    if (empty($_POST["email"])
                        || (!empty($_POST["email"]) && preg_match("/^[_a-z0-9-.]*@[_a-z0-9-.]*\.[a-z]{2,4}$/i", $_POST["email"]))) {
                        $update = "INSERT INTO news_kommentare (news_id, name, email, hp, time, text) 
							VALUES (
							'" . $_REQUEST['id'] . "',
							'" . save($_POST['name'], $link) . "',
							'" . save($_POST['email'], $link) . "',
							'" . save($_POST['hp'], $link) . "',
							'" . time() . "',
							'" . save($_POST['message'], $link) . "'
							)";
                        mysqli_query($link, $update) OR die(mysqli_error($link));
                        echo "<p class='ok'>Dein Kommentar ist eingegangen. Vielen Dank! Du wirst weitergeleitet...</p><br>";
                        echo "<meta http-equiv='refresh' content='1; URL=newsentry.php?id=" . $_REQUEST['id'] . "'>"; // Weiterleitung
                    } else {
                        echo "<p class='fault'>Deine Email-Adresse ist ungültig!</p><br>";
                    }
                } else {
                    echo "<p class='fault'>Dein Name ist ungültig!</p><br>";
                }
            } else {
                echo "<p class='fault'>Ein Feld wurde nicht ausgefüllt!</p><br>";
            }
        } else {
            echo "<p class='fault'>Der Sicherheitscode war falsch!</p><BR>";
        }
    }
}

echo "<script language='Javascript' src='bbcode.js'></script>";
echo "<form action='newsentry.php?action=comment&id=" . $_REQUEST['id'] . "' method='post' name='bbform'>";
echo "<table width='80%' class='commentinputs'>";
echo "<tr>";
echo "<td colspan='2'><h2><img src='webicons/comment.png' border='0'> Kommentar hinterlassen</h2></td>";
echo "</tr>";
echo "<tr>";
echo "<td width='28%'><b>Name</b> (*):</td>";
echo "<td><input type='text' name='name' value='" . (!empty($_POST['name']) ? $_POST['name'] : "") . "' class='textinput'></td>";
echo "</tr>";
echo "<tr>";
echo "<td width='28%'><b>E-Mail</b>:</td>";
echo "<td><input type='text' name='email' value='" . (!empty($_POST['email']) ? $_POST['email'] : "") . "' class='textinput'></td>";
echo "</tr>";
echo "<tr>";
echo "<td width='28%'><b>Homepage</b>:</td>";
echo "<td><input type='text' name='hp' value='" . (!empty($_POST['hp']) ? $_POST['hp'] : "") . "' class='textinput'></td>";
echo "</tr>";
echo "<tr>";
echo "<td width='28%'><b>Text</b> (*):</td>";
echo "<td>"
?>
<div class='commenttext'>
    <center>
        <img src="bbc/bold.gif" alt="fettgedruckter Text" title="fettgedruckter Text" border="0"
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
        <img src="bbc/list.gif" alt="Liste erstellen" title="Liste erstellen" border="0"
             onclick="dolist(document.bbform)" onmouseover="this.style.cursor='hand';"/></center>
    <?php
    echo "<textarea name='message' rows='5' cols='30'>" . (!empty($_POST['message']) ? $_POST['message'] : "") . "</textarea><br></div>";
    echo "<center><div class='gfx' style='text-align: center;'>" . smilies($link) . "</div>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td width='28%'><b>Captcha</b> (*):</td>";
    echo "<td><img src='sicher.php' name='capt' alt=''> ";
    echo "<input type='text' name='captcha' size='5' value='' maxlength='5'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td width='28%'>(*) Pflicht</td>";
    echo "<td><input type='submit' name='submit2' value='Kommentar eintragen!'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form><br></center>";
    echo "</div>";

    include("footer.php");
    ?>
