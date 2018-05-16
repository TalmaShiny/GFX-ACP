<?php
include("db.php");
if (is_numeric($_REQUEST["id"])) {
    $select = "SELECT id, downloads, zip FROM downloads WHERE id = '" . $_REQUEST["id"] . "'";
    $result = mysqli_query($link, $select);
    while ($row = mysqli_fetch_object($result)) {
        $hits = $row->downloads + 1;
        $update = "UPDATE downloads SET downloads = '" . $hits . "' WHERE id = '" . $_REQUEST["id"] . "'";
        $update2 = mysqli_query($link, $update);
        $url = $row->id . $row->zip;
    }
}
header("Location: Downloads/load" . $url . "");
?>
