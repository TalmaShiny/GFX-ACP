<?php
function xx($anfang, $ende, $html, $umwandlung)
{
    if (count(explode($anfang, $umwandlung)) == count(explode($ende, $umwandlung)) && count(explode($anfang, $umwandlung)) > 1) {
        while (count(explode($anfang, $umwandlung)) != 1) {
            $anfangx = strpos($umwandlung, $anfang) + strlen($anfang);
            $endex = strpos($umwandlung, "]", $anfangx) - 1;
            $code = substr($umwandlung, $anfangx, ($endex - $anfangx + 1));
            $umwandlung = str_replace($anfang . $code . "]", $html . $code . "'>", $umwandlung);
        }
    }
    return $umwandlung;
}

function ae($anfang, $ende, $htmla, $htmle, $umwandlung)
{
    if (count(explode($anfang, $umwandlung)) > 1) {
        while (count(explode($anfang, $umwandlung)) > 1) {
            $anfangx = strpos($umwandlung, $anfang) + strlen($anfang);
            $endex = strpos($umwandlung, $ende, $anfangx) - strlen($ende);
            $code = substr($umwandlung, $anfangx, ($endex - $anfangx + strlen($ende)));
            $alt = $anfang . $code . $ende;
            $neu = $htmla . $code . $htmle;
            $umwandlung = str_replace($alt, $neu, $umwandlung);
        }
    }
    return $umwandlung;
}

function w($anfang, $ende, $umwandlung)
{
    if (count(explode($anfang, $umwandlung)) > 1) {
        while (count(explode($anfang, $umwandlung)) > 1) {
            $anfangx = strpos($umwandlung, $anfang) + strlen($anfang);
            $endex = strpos($umwandlung, $ende, $anfangx) - strlen($ende);
            $code = substr($umwandlung, $anfangx, ($endex - $anfangx + strlen($ende)));
            $alt = $anfang . $code . $ende;
            $neu = $code;
            $neu = str_replace("[i]", "[i']'", htmlentities($neu));
            $umwandlung = str_replace($alt, $neu, $umwandlung);
        }
    }
    return $umwandlung;
}

function zurueck($string)
{
    $string = str_replace("&lt;", "<", $string);
    $string = str_replace("&gt;", ">", $string);
    $string = str_replace("&quot;", "\"", $string);
    $string = str_replace("&amp;", "&", $string);
    return $string;
}

function bbccode($umwandlung, $link)
{
    $umwandlung = w("[CODE]", "[/CODE]", $umwandlung);
    $umwandlung = w("[code]", "[/code]", $umwandlung);
    $umwandlung = str_replace("[b]", "<b>", $umwandlung);
    $umwandlung = str_replace("[B]", "<b>", $umwandlung);
    $umwandlung = str_replace("[/b]", "</b>", $umwandlung);
    $umwandlung = str_replace("[/B]", "</b>", $umwandlung);
    $umwandlung = str_replace("[u]", "<u>", $umwandlung);
    $umwandlung = str_replace("[U]", "<u>", $umwandlung);
    $umwandlung = str_replace("[/u]", "</u>", $umwandlung);
    $umwandlung = str_replace("[/U]", "</u>", $umwandlung);
    $umwandlung = str_replace("[i]", "<i>", $umwandlung);
    $umwandlung = str_replace("[I]", "<i>", $umwandlung);
    $umwandlung = str_replace("[/i]", "</i>", $umwandlung);
    $umwandlung = str_replace("[/I]", "</i>", $umwandlung);
    $umwandlung = str_replace("[center]", "<center>", $umwandlung);
    $umwandlung = str_replace("[CENTER]", "<center>", $umwandlung);
    $umwandlung = str_replace("[/center]", "</center>", $umwandlung);
    $umwandlung = str_replace("[/CENTER]", "</center>", $umwandlung);
    $umwandlung = str_replace("[/image]", "'>", $umwandlung);
    $umwandlung = str_replace("[/IMAGE]", "'>", $umwandlung);
    $umwandlung = str_replace("[/img]", "'>", $umwandlung);
    $umwandlung = str_replace("[/IMG]", "'>", $umwandlung);
    $umwandlung = str_replace("[IMAGE]", "<img border=0 src='", $umwandlung);
    $umwandlung = str_replace("[image]", "<img border=0 src='", $umwandlung);
    $umwandlung = str_replace("[IMG]", "<img border=0 src='", $umwandlung);
    $umwandlung = str_replace("[img]", "<img border=0 src='", $umwandlung);
    $umwandlung = str_replace("[/quote]", "</blockquote>", $umwandlung);
    $umwandlung = str_replace("[/QUOTE]", "</blockquote>", $umwandlung);
    $umwandlung = str_replace("[quote]", "<blockquote>", $umwandlung);
    $umwandlung = str_replace("[QUOTE]", "<blockquote>", $umwandlung);
    $umwandlung = ae("[list=1]", "[/list]", "<ol>", "</ol>", $umwandlung);
    $umwandlung = ae("[LIST=1]", "[/LIST]", "<ol>", "</ol>", $umwandlung);
    $umwandlung = ae("[LIST=a]", "[/LIST]", "<ol type=a>", "</ol>", $umwandlung);
    $umwandlung = ae("[list=a]", "[/list]", "<ol type=a>", "</ol>", $umwandlung);
    $umwandlung = str_replace("[list]", "<ul>", $umwandlung);
    $umwandlung = str_replace("[LIST]", "<ul>", $umwandlung);
    $umwandlung = str_replace("[/LIST]", "</ul>", $umwandlung);
    $umwandlung = str_replace("[/list]", "</ul>", $umwandlung);
    $umwandlung = str_replace("[*]", "<li>", $umwandlung);

    $umwandlung = str_replace("<br>", "\n", $umwandlung);
    if (count(explode("[PHP]", $umwandlung)) == count(explode("[/PHP]", $umwandlung)) && count(explode("[PHP]", $umwandlung)) > 1) {
        while (count(explode("[PHP]", $umwandlung)) > 1) {
            $anfang = strpos($umwandlung, "[PHP]") + 5;
            $ende = strpos($umwandlung, "[/PHP]") - 1;
            $code1 = substr($umwandlung, $anfang, ($ende - $anfang + 1));
            $code = zurueck($code1);
            $code = wordwrap($code, 80, "\n");
            $code = highlight_string($code, true);
            $umwandlung = str_replace("[PHP]" . $code1 . "[/PHP]", $code, $umwandlung);
        }
    }
    $umwandlung = xx("[URL=", "[/URL]", "<a target='_blank' href='", $umwandlung);
    $umwandlung = xx("[url=", "[/url]", "<a target='_blank' href='", $umwandlung);
    $umwandlung = str_replace("[/url]", "</a>", $umwandlung);
    $umwandlung = str_replace("[/URL]", "</a>", $umwandlung);

    $umwandlung = xx("[EMAIL=", "[/EMAIL]", "<a href='mailto:", $umwandlung);
    $umwandlung = xx("[email=", "[/email]", "<a href='mailto:", $umwandlung);
    $umwandlung = str_replace("[/email]", "</a>", $umwandlung);
    $umwandlung = str_replace("[/EMAIL]", "</a>", $umwandlung);

    $umwandlung = str_replace("[i']'", "[i]", $umwandlung);
    $umwandlung = str_replace("\n", "<br>", $umwandlung);
    $umwandlung = str_replace("&lt;br&gt;", "<br>", $umwandlung);

    $abfrage4 = "SELECT * FROM smilies";
    $ergebnis4 = mysqli_query($link, $abfrage4);
    while ($row4 = mysqli_fetch_object($ergebnis4)) {
        $code = htmlspecialchars($row4->code);
        $umwandlung = str_replace($code, "<img src='smilies/" . $row4->id . $row4->endung . "' border='0'>", $umwandlung);
    }
    return $umwandlung;
}

?>
