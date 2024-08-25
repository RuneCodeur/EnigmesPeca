<?php
//valeurs
$resultat = '';                     // message à afficher 
$classResultat = 'resultat-red';    // par defaut, affiche le message en rouge

//logique
if(isset($_POST['reponse']) && $_POST['reponse'] !=''){                         // si il y a la valeur "reponse" dans le renvois
    if ($_POST['reponse'] == "16"){                                             // si la réponse est correcte...
        $resultat = "gagné ! vous avez gagné l'indice suivant : Bannane";       // affiche le message de reussite
        $classResultat = 'resultat-green';                                      // affiche la réponse en vert
    }
    else{                                                                       // sinon...
        $resultat = "mauvaise reponse !";                                       // affiche le message d'echec
    }
}

//affichage
?>
<h1>Enigme 2</h1>
<p class="signature">par Henry JEAN-FURET</p>

<img src="./enigmes/documents/defaut.jpg">

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form class="formulaire_stylé" action="<?=lienEnigme("enigme2")?>" method="POST">
    <input class="bout_stylé" type="number" id="reponse" name="reponse">
    <input class="bout_action_stylé" type="submit">
</form>
