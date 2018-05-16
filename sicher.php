<?php
session_start();
include("funktionen.php");
$_SESSION["captchax"] = random(5);
header('Content-type: image/png');
$img = ImageCreateFromPNG("captcha/captcha.png");
$color = ImageColorAllocate($img, 255, 255, 255);
imagettftext($img, 11, rand(0, 5), rand(5, 10), 16, $color, "captcha/XFILES.TTF", $_SESSION['captchax']);
imagepng($img);
imagedestroy($img);
?>