<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ-geo01p';

// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);


// si l'equipe à déja proposé une réponse
if((isset($_POST['response']) && $_POST['response'] != '') || isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve])){
    if(isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]) || (strtolower(trim($_POST['response'])) == "diamant" || strtolower(trim($_POST['response'])) == "le diamant") ){

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

<h1>Un beau caillou</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_stylé">Quel minéral, souvent utilisé dans les bijoux, est formé de carbone pur ?</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        <input class="bout_stylé" type="text" id="response" name="response" placeholder="ma réponse" required>
        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
