<?php

class rating
{

    private $ratingid;
    private $itemid;
    private $wertung;
    private $ip;
    private $bereich;
    private $link;

    // Konstruktor
    public function __construct($link, $ratingid = null)
    {

        $this->link = $link;

        // Wenn Wert gesetzt ist
        if (!empty($ratingid)) {

            // Such-Statement
            $suchstring = "select * from rating where ratingid = '" . mysqli_real_escape_string($this->link, $ratingid) . "'";
            $result = mysqli_query($this->link, $suchstring);

            $row = mysqli_fetch_assoc($result);

            $this->setratingid($row['ratingid']);
            $this->setitemid($row['itemid']);
            $this->setwertung($row['wertung']);
            $this->setip($row['ip']);
            $this->setbereich($row['bereich']);
        }
    }

    // get und set-Methoden
    public function setratingid($ratingid)
    {
        $this->ratingid = strip_tags(mysqli_real_escape_string($this->link, $ratingid));
    }

    public function getratingid()
    {
        return $this->ratingid;
    }

    public function setitemid($itemid)
    {
        $this->itemid = strip_tags(mysqli_real_escape_string($this->link, $itemid));
    }

    public function getitemid()
    {
        return $this->itemid;
    }

    public function setwertung($wertung)
    {
        $this->wertung = strip_tags(mysqli_real_escape_string($this->link, $wertung));
    }

    public function getwertung()
    {
        return $this->wertung;
    }

    public function setip($ip)
    {
        $this->ip = strip_tags(mysqli_real_escape_string($this->link, $ip));
    }

    public function getip()
    {
        return $this->ip;
    }

    public function setbereich($bereich)
    {
        $this->bereich = strip_tags(mysqli_real_escape_string($this->link, $bereich));
    }

    public function getbereich()
    {
        return $this->bereich;
    }

    // prüfen, ob ip für dieses item bereits gewertet hat
    public function ipvoted()
    {

        // suchstring
        $suchstring = "select ratingid from rating where 
										 ip = '" . $this->getip() . "' and 
										 itemid = '" . $this->getitemid() . "' and 
										 bereich = '" . $this->getbereich() . "'";
        $result = mysqli_query($this->link, $suchstring);
        $ergebnis = mysqli_num_rows($result);

        if ($ergebnis > 0) {
            return true;
        } else {
            return false;
        }
    }

    // neues Rating anlegen
    public function create()
    {

        // Insert-Statement
        $insertstring = "insert into rating (itemid, wertung, ip, bereich) values
											 ('" . $this->getitemid() . "',
											 	'" . $this->getwertung() . "',
												'" . $this->getip() . "',
												'" . $this->getbereich() . "')";

        if (mysqli_query($this->link, $insertstring)) {
            return true;
        } else {
            return false;
        }
    }

    // Rating löschen
    public function delete()
    {

        // Delete-Statement
        $deletestring = "delete from rating where ratingid = '" . $this->getratingid() . "'";

        if (mysqli_query($this->link, $deletestring)) {
            return true;
        } else {
            return false;
        }
    }
}

// rating pro element zählen
function ratingszaehlen($itemid, $bereich, $link)
{

    // Suchstring
    $suchstring = "select count(ratingid) as anzahl, round((sum(wertung)/count(itemid)), 0) as rate from rating where 
									 itemid = '" . mysqli_real_escape_string($link, $itemid) . "' and 
									 bereich = '" . mysqli_real_escape_string($link, $bereich) . "'";
    $result = mysqli_query($link, $suchstring);
    $row = mysqli_fetch_assoc($result);

    $inhalt = array();

    $inhalt['anzahl'] = $row['anzahl'];
    $inhalt['rate'] = $row['rate'];

    return $inhalt;
}

?>
