<?php
require_once('./functions.php');

$url = $_GET['url'];

$name = $_GET['name'] . ".png";

$QRcodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);

$image = file_get_contents($QRcodeUrl);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $name . '"');
header('Content-Length: ' . strlen($image));
header('Cache-Control: must-revalidate');
header('Pragma: public');

echo $image;
exit;