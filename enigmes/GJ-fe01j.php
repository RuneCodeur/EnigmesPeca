<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ-fe01j';

// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);


// si l'equipe à déja proposé une réponse
if((isset($_POST['response']) && $_POST['response'] != '') || isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve])){
    if(isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]) || strtolower($_POST['response']) == 100 ){

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

<h1>Comment cuir des pates ?</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_stylé">À quelle température en degrés (Celsius), l'eau commence-t-elle à bouillir ?</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        <input type="number" name="response" value="0" min="0" max="1000">
        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>