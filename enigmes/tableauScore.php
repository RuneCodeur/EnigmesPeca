<?php

//valeurs
$fichier = './enigmes/documents/stat.json';     // nom du fichier utilisé pour l'enregistrement
$equipes = [];                                  // liste utilisé pour afficher les equipes

//logique
$json = file_get_contents($fichier);            // récupère le contenue du fichier 
$equipes = json_decode($json, true);            // converti le contenue en un format utilisable

//affichage
?>

<h1>tableau des scores</h1>
<ul class="liste-simple">
    <?php
    foreach ($equipes as $nom => $score) {
        ?>
        <li><p><?=$nom?> :</p> <?=$score?></li>
        <?php
    }
    ?>
</ul>
