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