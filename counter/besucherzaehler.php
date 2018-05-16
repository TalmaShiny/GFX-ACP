<?php

$besucherzaehler = new besucherzaehler($link);
$besucherzaehler->setip(getenv("REMOTE_ADDR"));
$besucherzaehler->settimestamp(time());
$besucherzaehler->setdatum(date("Y-m-d"));

if ($besucherzaehler->ipdatumexist()) {
    $besucherzaehler->update();
} else {
    $besucherzaehler->create();
}

?>
