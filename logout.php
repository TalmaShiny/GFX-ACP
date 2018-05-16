<?php
//Löscht alle Sessions
ob_start();
session_start();
session_unset();
session_destroy();
ob_end_flush();
//Zurück zum Login
echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php\">";
?>
