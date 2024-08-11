<?php
//valeurs
$fichier = './enigmes/documents/stat.json';
$action = '';
$message = '';

//logique
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if($action == '1'){
    session_destroy();
    $message = 'session vidé !';
}

elseif($action == '2'){
    $json = json_encode([], JSON_PRETTY_PRINT);
    file_put_contents($fichier, $json);
    $message = 'fichier "stat.json" vidé !';
}

//affichage
?>
<h1>parametres</h1>

<p class="resultat resultat-green">
    <?= $message ?>
</p>

<a href ='<?=route_dossier()?>?admin=jaimeleschats&param=1&action=1' >vider la session</a>
<a href ='<?=route_dossier()?>?admin=jaimeleschats&param=1&action=2' >vider le fichier "stat.json"</a>
