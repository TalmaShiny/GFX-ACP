<?php
include("header.php");

echo "<h1>Become Affiliate</h1>";
echo "Hier könnten deine Bewerbungsbedingungen hin!<br><br><br>";

if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "new") {
    if (!empty($_POST["name"])) {
        if (!empty($_POST["url"])) {
            if (!empty($_POST["button"])) {
                if (isset($_SESSION["captchax"]) && $_SESSION["captchax"] == $_REQUEST["code"]) {
                    unset($_SESSION["captchax"]);
                    $eintrag = "INSERT INTO affisbecome
						(name, url, button) VALUES(
						'" . save($_POST["name"], $link) . "', 
						'" . save($_POST["url"], $link) . "', 
						'" . save($_POST["button"], $link) . "')";
                    $ausfuehren = mysqli_query($link, $eintrag) OR die(mysqli_error($link));
                    echo "<p class='ok'>Bewerbung erfolgreich abgesendet. Vielen Dank!</p><br>";
                } else {
                    echo "<p class='fault'>Der Sicherheitscode ist falsch!</p><br>";
                }
            } else {
                echo "<p class='fault'>Der Button fehlt!</p><br>";
            }
        } else {
            echo "<p class='fault'>Die Homepageurl fehlt!</p><br>";
        }
    } else {
        echo "<p class='fault'>Der Homepagename fehlt!</p><br>";
    }
}
?>

<form action="becomeaffi.php?action=new" method="post">
    <table class='commentinputs'>
        <tr>
            <td colspan='2'><h2><img src='webicons/comment.png' border='0'> Bewerbungsformular</h2></td>
        </tr>
        <tr>
            <td width="30%"><b>Homepagename:</b></td>
            <td width="60%"><input type="text" name="name" size="30"
                                   value="<?= (!empty($_POST['name']) ? $_POST['name'] : ''); ?>"></td>
        </tr>
        <tr>
            <td width="30%"><b>Homepage URL:</b></td>
            <td width="60%"><input type="text" name="url" size="30" class="inputx"
                                   value="<?= (!empty($_POST['url']) ? $_POST['url'] : ''); ?>">
            </td>
        </tr>
        <tr>
            <td width="30%"><b>Button URL:</b><br/>88*31 Pixel</td>
            <td width="60%"><input type="text" name="button" size="30"
                                   value="<?= (!empty($_POST['button']) ? $_POST['button'] : ''); ?>"></td>
        </tr>
        <tr>
            <td width="30%"><b>Captcha:</b></td>
            <td width="60%"><img src="sicher.php" border="0"> <input type="text" name="code" size="5"></td>
        </tr>
        <tr>
            <td width="30%"></td>
            <td width="60%"><input type="submit" value="Bewerbung senden"></td>
        </tr>
    </table>
</form>
<?php
include("footer.php");
?>
