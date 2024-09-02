<?php

function route_dossier() {
    $HTTP = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $HTTP = 'https';
    }

    $Route = $HTTP.'://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);

    if(substr($Route, -1) === '/'){
        $Route = substr($Route, 0, -1);
    }
    
    return $Route;
}

function lienEnigme($nom = ""){
    $lien = "./";
    if($nom != ""){
        $lien .=  '?id=' . $nom;
    }
    return $lien;
}

function testTeam($fichierTeam, $retour){
    
    if(isset($_SESSION['admin-pseudo']) && isset($_SESSION['admin-password'])){
        $_SESSION['admin-pseudo'] = null;
        $_SESSION['admin-password']= null;
    }

    if(!isset($_SESSION['equipe'])){
        header('Location: '.lienEnigme($retour));
        die;
    }
    
    $equipes = GETfichier($fichierTeam);
    if (!array_key_exists($_SESSION['equipe'], $equipes)) {
        session_destroy();
        header('Location: '.lienEnigme($retour));
        die;
    }
}

function GETfichier($fichier){
    $json = file_get_contents($fichier);
    return json_decode($json, true);
}

function UPDATEfichier($fichier, $info){
    $json = json_encode($info, JSON_PRETTY_PRINT);
    file_put_contents($fichier, $json);
}

function GETqrcode($url, $name){
    return "./model/imageQRCODE.php?url=" . urlencode($url) . "&name=" . $name;
}