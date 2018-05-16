<?php
include("db.php");
if (is_numeric($_REQUEST["id"])) {
    $select = "SELECT hits,url FROM affis WHERE id = '" . $_REQUEST["id"] . "'";
    $result = mysqli_query($link, $select);
    while ($row = mysqli_fetch_object($result)) {
        $hits = $row->hits + 1;
        $update = "UPDATE affis SET hits = '" . $hits . "' WHERE id = '" . $_REQUEST["id"] . "'";
        $update2 = mysqli_query($link, $update);
        $url = $row->url;
    }
}
header("Location: " . $url . "");
?>
