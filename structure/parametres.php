<?php
//valeurs
$fichierTeam = './enigmes/documents/team.json';
$fichierTeam2 = './enigmes/documents/team-GJ2.json';
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
    UPDATEfichier($fichierTeam, []);
    $message = 'fichier "team.json" vidé !';
}

elseif($action == '3'){
    UPDATEfichier($fichierTeam2, []);
    $message = 'fichier "team-GJ2.json" vidé !';
}

//affichage
?>
<h1>parametres</h1>

<p class="resultat resultat-green">
    <?= $message ?>
</p>

<a href ='<?=route_dossier()?>?admin=jaimeleschats&param=1&action=1' >vider la session</a>
<a href ='<?=route_dossier()?>?admin=jaimeleschats&param=1&action=2' >vider le fichier "team.json"</a>
<a href ='<?=route_dossier()?>?admin=jaimeleschats&param=1&action=3' >vider le fichier "team-GJ2.json"</a>
