<?php
include('header.php');

if (isset($_SESSION['acp'])) { // Wenn eingeloggt..

    if (isset($_POST['submit2'])) {
        if (is_numeric($_REQUEST['id'])) {
            if (!empty($_POST['name']) && !empty($_POST['url']) && !empty($_POST['button'])) {
                $update = "UPDATE affis SET 
					name = '" . save($_POST['name'], $link) . "',
					url = '" . save($_POST['url'], $link) . "',
					button = '" . save($_POST['button'], $link) . "'
					WHERE id = '" . $_REQUEST['id'] . "'";

                $update_a = mysqli_query($link, $update) OR die(mysqli_error($link));
                echo "<p class='ok'>Affiliate editiert.</p><br>";
            } else {
                echo "<p class='fault'>Ein Feld wurde nicht ausgefüllt!</p><br>";
            }
        }
    }
    if (isset($_GET['action']) == "edit" && is_numeric($_GET['id'])) {
        $abfrage = "SELECT * FROM affis WHERE id ='" . htmlspecialchars($_GET["id"]) . "'";
        $ergebnis = mysqli_query($link, $abfrage);
        while ($row = mysqli_fetch_object($ergebnis)) {
            echo "<h1>Edit Affi - " . $row->titel . "</h1>";
            echo "<form acton='' method='POST'>
					<table>
						<tr>
							<td></td>
							<td><img src='" . $row->button . "'></td>
						</tr>
						<tr>
							<td>Name</td>
							<td><input type='text' name='name' value='" . $row->name . "'></td>
						</tr>
						<tr>
							<td>URL</td>
							<td><input type='text' name='url' value='" . $row->url . "'></td>
						</tr>
						<tr>
							<td>Button-URL</td>
							<td><input type='text' name='button' value='" . $row->button . "'></td>
						</tr>
						<tr>
							<td></td>
							<td><input type='submit' name='submit2' value='Edit' /></td>
						</tr>
					</table>
				</form>";
        }
    }
} else {
    echo "<center><br>Du hast keinen Zutritt!</center>";
}
include("footer.php");
?>
