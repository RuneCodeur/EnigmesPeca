<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'fe02u';


// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);

// initialisation des valeurs
if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] = '';
    UPDATEfichier($fichierTeam, $equipes);
}
if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 3;
    UPDATEfichier($fichierTeam, $equipes);
}

// insertion de la réponse + décompte
if( isset($_POST['response']) && $_POST['response'] !=''  &&  $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] > 0 ){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] = trim($_POST['response']);
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] -1 ;
    UPDATEfichier($fichierTeam, $equipes);
}

// si l'equipe à déja proposé une réponse
if(isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response']) && $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] != ''){
    if(strtolower($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response']) == "oxygène" || strtolower($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response']) == "l'oxygène" || strtolower($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response']) == "de l'oxygène"){

        // bonne réponse
        $resultat = 'Bonne réponse ! Votre équipe gagne 3 point !';
        $classResultat = 'resultat-green';
        $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 0;
        if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
            $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
            $equipes[$_SESSION['equipe']]['score'] = $equipes[$_SESSION['equipe']]['score']+3;
            UPDATEfichier($fichierTeam, $equipes);
        }
        $afficheFormulaire = false;
    }

    // mauvaise réponse, mais reste des essaies
    elseif ($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] >= 1) {
        $resultat = 'mauvaise réponse ! indice: tu en as besoin aussi pour vivre';
    }

    // mauvaise réponse, plus d'essaie
    else{
        $resultat = 'perdu ! passez à l\'enigme suivante';
        $afficheFormulaire = false;
    }
}

// affichage
?>

<h1>Trinité enflammé</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentatives.</p>

<p class="texte_stylé">Complète le triangle du feu en identifiant le troisième élément manquant.</p>

<br>

<img src="./enigmes/documents/enigme4.png">

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme("GJ-".$nomEpreuve)?>" method="POST">
        <input type="text" name="response" placeholder="ma réponse" required>
        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>