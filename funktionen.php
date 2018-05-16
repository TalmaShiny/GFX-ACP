<?php
function exist($abfrage, $link)
{
    $ergebnis3 = mysqli_query($link, "SELECT id FROM " . $abfrage);
    if (mysqli_fetch_object($ergebnis3)) {
        return true;
    } else {
        return false;
    }
}

function random($anzahl, $nurb = false)
{
    if ($nurb) {
        $alle = "ABCDEFGHJKLMNPRSTUVWXYZ";
    } else {
        $alle = "ABCDEFGHJKLMNPRSTUVWXYZ123456789";
    }
    $str = "";
    while (strlen($str) < $anzahl) {
        $str = $str . substr($alle, rand(0, (strlen($alle) - 1)), 1);
    }

    return ($str);
}

function wert($abfragez, $value, $link)
{
    $abfrage = "SELECT " . $value . " AS value FROM " . $abfragez . " LIMIT 0,1";
    $ergebnis = mysqli_query($link, $abfrage);
    $row = mysqli_fetch_array($ergebnis);

    return $row['value'];
}

function anzahl($abfragez, $link)
{
    $ergebnis = mysqli_query($link, "SELECT COUNT(*) AS anzahl FROM " . $abfragez);
    $row = mysqli_fetch_array($ergebnis);

    return $row['anzahl'];
}

function refresh($user, $link)
{
    $update = mysqli_query($link, "UPDATE benutzer SET refresh = '" . time() . "' WHERE id = '" . $user . "'");
}

function endung($filename)
{
    $end = explode(".", $filename);

    return "." . $end[(count($end) - 1)];
}

function save($text, $link)
{
    $textnew = mysqli_real_escape_string($link, $text);

    return $textnew;
}

function smilies($link)
{
    $a = 0;
    $pro = 9;
    $s = "";
    $abfrage = "SELECT * FROM smilies ORDER BY id";
    $ergebnis = mysqli_query($link, $abfrage);
    while ($row = mysqli_fetch_object($ergebnis)) {
        if ($a % $pro == 0 && $a != 0) {
            $s = $s . "<br>";
        }
        $s .= "<a onclick=\"smilie('" . $row->code . "')\"><img src=\"smilies/" . $row->id . "" . $row->endung . "\" border=0></a>&nbsp;";
        $a++;
    }
    $smilies = $s;

    return $smilies;
}

?>
