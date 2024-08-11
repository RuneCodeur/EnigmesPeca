<?php
//valeurs
$url = route_dossier() . '?id=' . $GETcode;

$QRcode = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);

//logique

//affichage
?>

<h1>qr code</h1>

<img src='<?=$QRcode?>' alt='QR code' />