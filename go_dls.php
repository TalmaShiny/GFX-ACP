<?php
include("db.php");
if (is_numeric($_REQUEST["id"])) {
    $select = "SELECT id, views FROM downloads WHERE id = '" . $_REQUEST["id"] . "'";
    $result = mysqli_query($link, $select);
    while ($row = mysqli_fetch_object($result)) {
        $hits = $row->views + 1;
        $update = "UPDATE downloads SET views = '" . $hits . "' WHERE id = '" . $_REQUEST["id"] . "'";
        $update2 = mysqli_query($link, $update);
        $url = $_REQUEST['id'];
    }
}
header("Location: dl.php?action=more&id=" . $url . "");
?>
