<?php
//valeurs
$DosEnigmes = scandir("./enigmes");
$Enigmes = [];


//logique
foreach ($DosEnigmes as $id => $file) {
    if($file != '.' && $file != '..' && $file != 'documents'){
        $Enigmes[] = $file;
    }
}

//affichage
?>
<h1>liste des enigmes</h1>
<a class="link" href ='<?=route_dossier()?>?admin=jaimeleschats&param=1'>parametres</a>
<ul class="list-accueil">
    <?php
    foreach ($Enigmes as $Enigme) {
        ?>
            <li>
                <a class="link" href ='<?=route_dossier() . '?id=' . substr($Enigme, 0,-4)?>'><?=substr($Enigme,  0,-4)?></a>
                <a class="code" href ='<?=route_dossier() . '?qr=' . substr($Enigme, 0,-4)?>'>QR-code</a>

            </li>
        <?php
    }
    ?>
</ul>