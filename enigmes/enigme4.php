<?php
//valeurs
$resultat = '';                     // message à afficher 
$classResultat = 'resultat-red';    // par defaut, affiche le message en rouge
$afficheFormulaire = true;          // pour choisir si on affiche le formulaire (par defaut, oui)

if(!isset($_SESSION['responseB'])){     // initialise la valeur 'responseB' dans la session du joueur (si elle n'existe pas)
    $_SESSION['responseB'] = '';
}
if(!isset($_SESSION['comptageB'])){     // initialise la valeur 'comptageB' à 3 dans la session du joueur (si elle n'existe pas)
    $_SESSION['comptageB'] = 3;
}

//logique
if( isset($_POST['reponse']) && $_POST['reponse'] !=''  &&  $_SESSION['comptageB'] > 0 ){   // si il y a la valeur "reponse" dans le renvois ET la valeur "comptageB" de la session est superieur à 0
    $_SESSION['responseB'] = $_POST['reponse'];                                             // donne la réponse donnée dans la session
    $_SESSION['comptageB'] = $_SESSION['comptageB'] -1 ;                                    // décompte de 1 la valeur 'comptageB' du joueur
}

if(isset($_SESSION['responseB'])){                                                                                                          // si une réponse se trouve dans la session du joueur
    if($_SESSION['responseB'] == "Dragon Ball" || $_SESSION['responseB'] == "dragon ball" || $_SESSION['responseB'] == "Dragon ball" ){     // si la réponse est correcte... 
        $resultat = 'gagné ! tu as droit à un indice : nuage magique';                                                                      // affiche le message de reussite
        $classResultat = 'resultat-green';                                                                                                  // affiche la réponse en vert
        $_SESSION['comptageB'] = 0;                                                                                                         // réduit le comptage à 0
        $afficheFormulaire = false;                                                                                                         // masque le formulaire
    }
    elseif ($_SESSION['comptageB'] >= 1) {                                                                                                  // si il reste des coups à jouer...
        $resultat = 'mauvaise réponse !';                                                                                                   // affiche un message d'erreur
    }
    else{                                                                                                                                   // sinon...
        $resultat = 'perdu ! passez à l\'enigme suivante';                                                                                  // indique au joueur qu'il n'a plus de coup à jouer
        $afficheFormulaire = false;                                                                                                         // bloque le formulaire
    }
}

//affichage
?>

<h1>enigme 4</h1>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$_SESSION['comptageB']?> tentatives.</p>

<p class="texte_stylé"> Donne moi le nom du manga avec un enfant qui possède un kimono orange et une queue de singe.</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé" action="<?=lienEnigme("enigme4")?>" method="POST">
        <input class="bout_stylé" type="text" id="reponse" name="reponse">
        <input class="bout_action_stylé" type="submit">
    </form>

    <?php 
    }
?>
