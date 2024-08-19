<?php
//valeurs
$resultat = '';                     // message à afficher 
$classResultat = 'resultat-red';    // par defaut, affiche le message en rouge
$afficheFormulaire = true;          // pour choisir si on affiche le formulaire (par defaut, oui)

//logique
if(isset($_POST['reponse']) && $_POST['reponse'] !='' && !isset($_SESSION['responseA'])){   // si il y a la valeur "reponse" dans le renvois ET la valeur "responseA" n'existe pas dans la session du joueur...
    $_SESSION['responseA'] = $_POST['reponse'];                                             // place la réponse du joueur dans la session (sous le nom de "responseA")
}

if(isset($_SESSION['responseA'])){                                                          // si il y a la valeur "reponse" dans la session du joueur...
    $afficheFormulaire = false;                                                             // masque le formulaire
    if(strtolower($_SESSION['responseA']) == "blanc" ){            // si la reponse est correcte
        $resultat = 'gagné ! tu as droit à un indice : Cornemuse';                          // affiche le message de reussite
        $classResultat = 'resultat-green';                                                  // affiche la réponse en vert
    }
    else{                                                                                   // sinon...
        $resultat = 'perdu ! passez à l\'enigme suivante';                                  // affiche le message d'echec
    }
}

//affichage
?>

<h1>enigme 3</h1>
<p class="signature">par Henry JEAN-FURET</p>

<p class="texte_alerte">ATTENTION : vous avez droit qu'a 1 seule tentative.</p>

<p class="texte_stylé"> de quel couleur etait le cheval blanc de Henry IV ?</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé" action="<?=lienEnigme("enigme3")?>" method="POST">
        <input class="bout_stylé" type="text" id="reponse" name="reponse">
        <input class="bout_action_stylé" type="submit">
    </form>

    <?php 
    }
?>
