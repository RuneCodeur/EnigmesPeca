<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'vsm03u';

// logique
testTeam();
$json = file_get_contents($fichierTeam);
$teams = json_decode($json, true);


// si l'equipe à déja proposé une réponse
if((isset($_POST['reponse']) && $_POST['reponse'] != '') || isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve])){
    if(isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]) || (strtolower($_POST['reponse']) == "baleine bleue" || strtolower($_POST['reponse']) == "la baleine bleue") ){

        // bonne réponse
        $resultat = 'Bonne réponse ! Votre équipe gagne 1 point !';
        $classResultat = 'resultat-green';
        if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
            $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
            $teams[$_SESSION['equipe']]['score'] = $teams[$_SESSION['equipe']]['score']+1;
            $json = json_encode($teams, JSON_PRETTY_PRINT);
            file_put_contents($fichierTeam, $json);
        }
        $afficheFormulaire = false;
    }

    // mauvaise réponse, plus d'essaie
    else{
        $resultat = 'mauvaise réponse !';
    }
}

// affichage
?>

<h1>Question facile</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_stylé">Quel est le plus grand animal marin vivant aujourd'hui ?</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme("GJ-".$nomEpreuve)?>" method="POST">
        <input class="bout_stylé" type="text" id="reponse" name="reponse" placeholder="ma réponse">
        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
