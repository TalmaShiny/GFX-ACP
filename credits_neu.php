<?php
include("header.php");
if (isset($_SESSION["acp"])) { // Wenn eingeloggt..

    if (isset($_POST['hochladen'])) { // Wenn Formular abgeschickt, dann..
        $eintrag = "INSERT INTO credits (typ, name, url) VALUES (
			'" . save($_POST['typ'], $link) . "',
			'" . save($_POST['name'], $link) . "',
			'" . save($_POST['url'], $link) . "')";
        $eintragen = mysqli_query($link, $eintrag);
        if (mysqli_errno($link) == 0) { // Wenn MySQL keine Fehler hat dann...
            echo "<p class='ok'>Credit erfolgreich eingetragen!</p><br>";
            echo "<meta http-equiv='refresh' content='1; URL=creditsverwalten.php'>";
        } else { // Wenn MySQL Fehler..
            echo "<p class='fault'>Fehler " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
        }
    }
    ?>

    <h1>Neuen Credit hinzufügen</h1>
    <br>

    <form action="credits_neu.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Typ:</td>
                <td>
                    <select name='typ'>
                        <option value='inspiration'>Inspiration</option>
                        <option value='tutorial'>Tutorial</option>
                        <option value='brushes'>Brushes</option>
                        <option value='texture'>Texture</option>
                        <option value='sonstiges'>Sonstiges</option>
                </td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type='text' name='name'></td>
            </tr>
            <tr>
                <td>URL:<br></td>
                <td><input type="text" name="url" value="http://"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Hochladen!" name="hochladen"></td>
            </tr>
        </table>
    </form>
    <?php
} else {
    echo "<center><br>Du hast keinen Zutritt!</center>";
}
include('footer.php');
?>
