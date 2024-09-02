<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ-vsm01u';

// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);


// si l'equipe à déja proposé une réponse
if((isset($_POST['reponse']) && $_POST['reponse'] != '') || isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve])){
    if(isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]) || (strtolower(trim($_POST['reponse'])) == "baleine bleue" || strtolower(trim($_POST['reponse'])) == "la baleine bleue") ){

        // bonne réponse
        $resultat = 'Bonne réponse ! Votre équipe gagne 1 point !';
        $classResultat = 'resultat-green';
        if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
            $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
            $equipes[$_SESSION['equipe']]['score'] = $equipes[$_SESSION['equipe']]['score']+1;
            UPDATEfichier($fichierTeam, $equipes);
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

<h1>Un gros poisson</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_stylé">Quel est le plus grand animal marin vivant aujourd'hui ?</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        <input class="bout_stylé" type="text" id="reponse" name="reponse" placeholder="ma réponse">
        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
