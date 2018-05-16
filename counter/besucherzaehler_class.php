<?php

class besucherzaehler
{

    private $ip;
    private $timestamp;
    private $datum;
    private $link;

    // Konstruktor
    public function __construct($link)
    {
        $this->link = $link;
    }

    // get und set-methoden
    public function setip($ip)
    {
        $this->ip = strip_tags(mysqli_real_escape_string($this->link, $ip));
    }

    public function getip()
    {
        return $this->ip;
    }

    public function settimestamp($timestamp)
    {
        $this->timestamp = strip_tags(mysqli_real_escape_string($this->link, $timestamp));
    }

    public function gettimestamp()
    {
        return $this->timestamp;
    }

    public function setdatum($datum)
    {
        $this->datum = strip_tags(mysqli_real_escape_string($this->link, $datum));
    }

    public function getdatum()
    {
        return $this->datum;
    }

    // ip prüfen, ob richtig ist
    public function checkip()
    {

        $zeichen = "/[0-9a-z.:]/i";
        if (!preg_match($zeichen, $this->getip())) {
            return true;
        } else {
            return false;
        }
    }

    // prüfen, ob kombination von ip und datum bereits vorhanden ist
    public function ipdatumexist()
    {

        $suchstring = "select ip from besucherzaehler where ip = '" . $this->getip() . "' and datum = '" . $this->getdatum() . "'";
        $result = mysqli_query($this->link, $suchstring);
        $ergebnis = mysqli_num_rows($result);

        if ($ergebnis > 0) {
            return true;
        } else {
            return false;
        }
    }

    // neuen eintrag hinzufügen
    public function create()
    {

        $insertstring = "insert into besucherzaehler (ip, timestamp, datum) values
											 ('" . $this->getip() . "',
											  '" . $this->gettimestamp() . "',
												'" . $this->getdatum() . "')";

        if (mysqli_query($this->link, $insertstring)) {
            return true;
        } else {
            return false;
        }
    }

    // eintrag updaten
    public function update()
    {

        $updatestring = "update besucherzaehler set timestamp = '" . $this->gettimestamp() . "' where 
											 ip = '" . $this->getip() . "' and datum = '" . $this->getdatum() . "'";

        if (mysqli_query($this->link, $updatestring)) {
            return true;
        } else {
            return false;
        }
    }

    // löschen nicht nötig, da wichtig für statistik
}

// Funktionen
// Besucher online zählen
function countbesucheronline($timestamp, $link)
{

    $suchstring = "select count(ip) as ergebnis from besucherzaehler where timestamp >= " . ($timestamp - 300);
    $result = mysqli_query($link, $suchstring);
    $row = mysqli_fetch_assoc($result);

    return $row['ergebnis'];
}

// Besucher an einem bestimmten Tag ermitteln
function countbesuchertag($datum, $link)
{

    $suchstring = "select count(ip) as ergebnis from besucherzaehler where datum = '" . $datum . "'";
    $result = mysqli_query($link, $suchstring);
    $row = mysqli_fetch_assoc($result);

    return $row['ergebnis'];
}

// Besucher insgesamt ermitteln
function countbesuchergesamt($link)
{

    $suchstring = "select count(ip) as ergebnis from besucherzaehler";
    $result = mysqli_query($link, $suchstring);
    $row = mysqli_fetch_assoc($result);

    return $row['ergebnis'];
}

// meisten besucher ermitteln
function maxbesucher($link)
{

    $suchstring = "select count(ip) as anzahl, date_format(datum, '%d.%m.%Y') as datum from besucherzaehler group by datum having anzahl = (select max(count) as max from (select count(ip) as count from besucherzaehler group by datum) as rechnen) order by datum desc limit 0,1";
    $result = mysqli_query($link, $suchstring);
    $row = mysqli_fetch_assoc($result);

    return $row;
}

function test($link)
{

    $suchstring = "select count(ip) as anzahl from besucherzaehler group by datum where anzahl = max(anzahl)";
    $result = mysqli_query($link, $suchstring);
    $row = mysqli_fetch_assoc($result);

    echo mysqli_error($this->link);
}

?>
