<?php
/*
PROCESS
faire un scenario
faire au moins 5 enigmes pour chaque themes. 

vie sous-marine     ok
meteo               5
technologie         5
physique            5
les éléments        5
l'eau               5

bonus - chaque enigme fournis un indice pour répondre à la question suprème
si l'enigme est déja repondu, on peu pas repondre à nouveau

*/


ini_set('session.gc_maxlifetime', 60*60*5);
session_start();
ob_start();
require_once('./model/functions.php');

$DosEnigmes = scandir("./enigmes");
$Enigmes = [];
$GETenigme = '';
$GETcode = '';
$GETadmin = '';
$GETparam = '';

if(isset($_GET['id'])){
    $GETenigme = $_GET['id'];
}
if(isset($_GET['qr'])){
    $GETcode = $_GET['qr'];
}
if(isset($_GET['admin'])){
    $GETadmin = $_GET['admin'];
}
if(isset($_GET['param'])){
    $GETparam = $_GET['param'];
}

//enigmes
if($GETenigme != ''){
    if(is_file('./enigmes/'.$GETenigme.'.php')){
        require_once('./enigmes/'.$GETenigme.'.php');
    }
    else{
        echo "enigme inconnu - ".$GETenigme;
    }
}

//affichage du QR code
elseif($GETcode != ''){
    require_once('./structure/qrcode.php');
}


//affichage de la liste des enigmes (admin)
elseif($GETadmin == 'jaimeleschats'){
    if($GETparam == '1'){
        require_once('./structure/parametres.php');

    }else{
        require_once('./structure/listeEnigmes.php');

    }
}

//page d'accueil
else{
    require_once('./structure/accueil.php');
}

require_once('./structure/template.php');
echo ob_get_clean();