<?php
//valeurs
$url = route_dossier() . '?id=' . $GETcode;

$name = $GETcode;
$QRcode = GETqrcode($url, $name);

//logique

//affichage
?>

<h1>qr code</h1>
<p><?=$GETcode?></p>
<br>
<img src='<?=$QRcode?>' alt='QR code'/>
