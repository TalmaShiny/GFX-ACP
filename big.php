<?php
include("db.php");
include("funktionen.php");

$abfrage = "SELECT views FROM gfx WHERE id = '" . save($_REQUEST["id"], $link) . "'";
$ergebnis = mysqli_query($link, $abfrage) OR die(mysqli_error($link));
while ($row = mysqli_fetch_object($ergebnis)) {
    $views = $row->views + 1;
    $update = "UPDATE gfx SET 
		views = '" . save($views, $link) . "' 
		WHERE id = '" . save($_REQUEST["id"], $link) . "'";
    $update_a = mysqli_query($link, $update);
}
?>
<html>
<title>Gfx View</title>
<head></head>
<body bgcolor="#EBEBFA">
<center>
    <table width="100%" height="100%">
        <tr>
            <td width="100%" height="100%" align="center" valign="middle">
                <img src="<?= $_REQUEST["image"]; ?>" border="0" style="border:10px solid #3199BC; padding: 12px;
					background-color: #F5F5F5; border: 1px solid #D2D2D2; -moz-border-radius-topleft: 4px; 
					-moz-border-radius-topright: 4px; -moz-border-radius-bottomleft: 4px; 
					-moz-border-radius-bottomright: 4px;">
            </td>
        </tr>
    </table>
</center>
<div style='position:absolute; left:88%; top:97%; width:150px; color:#501E93; font-family:Arial; font-size:10px;'>ACP by
    Isa and The-Peril.com
</div>
</body>
</html>
