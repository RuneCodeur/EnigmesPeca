<?php
//valeurs
$resultat = '';                     // message à afficher 
$classResultat = 'resultat-red';    // par defaut, affiche le message en rouge

//logique
if(isset($_POST['reponse']) && $_POST['reponse'] !=''){                         // si il y a la valeur "reponse" dans le renvois
    if ($_POST['reponse'] == "un marron"){                                      // si la réponse est correcte...
        $resultat = "gagné ! vous avez gagné l'indice suivant : cuillère";      // affiche le message de reussite
        $classResultat = 'resultat-green';                                      // affiche la réponse en vert
    }
    else{                                                                       // sinon...
        $resultat = "perdu !";                                                  // affiche le message d'echec
    }
}

//affichage
?>
<h1>enigme 1</h1>

<p class="texte_stylé">Qu'es-ce qui est petit et marron ?</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form class="formulaire_stylé" action="<?=lienEnigme("enigme1")?>" method="POST">
    <input class="bout_stylé" type="text" id="reponse" name="reponse">
    <input class="bout_action_stylé" type="submit">
</form>
