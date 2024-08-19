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

function testTeam(){
    
    if(isset($_SESSION['admin-pseudo']) && isset($_SESSION['admin-password'])){
        $_SESSION['admin-pseudo'] = null;
        $_SESSION['admin-password']= null;
    }

    if(!isset($_SESSION['equipe'])){
        header('Location: '.lienEnigme("GJ-intro"));
        die;
    }
    
    $fichierTeam = './enigmes/documents/team.json'; 
    $json = file_get_contents($fichierTeam);
    $equipes = json_decode($json, true);
    if (!array_key_exists($_SESSION['equipe'], $equipes)) {
        session_destroy();
        header('Location: '.lienEnigme("GJ-intro"));
        die;
    }
}