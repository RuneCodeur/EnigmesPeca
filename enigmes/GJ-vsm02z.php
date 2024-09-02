<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ-vsm02z';

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
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] = $_POST['response'];
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] -1 ;
    UPDATEfichier($fichierTeam, $equipes);
}

// si l'equipe à déja proposé une réponse
if(isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response']) && $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] != ''){
    if($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] == 4 ){

        // bonne réponse
        $resultat = 'Bonne réponse ! Votre équipe gagne 2 point !';
        $classResultat = 'resultat-green';
        $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 0;
        if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
            $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
            $equipes[$_SESSION['equipe']]['score'] = $equipes[$_SESSION['equipe']]['score']+2;
            UPDATEfichier($fichierTeam, $equipes);
        }
        $afficheFormulaire = false;
    }

    // mauvaise réponse, mais reste des essaies
    elseif ($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] >= 1) {
        $resultat = 'mauvaise réponse !';
    }

    // mauvaise réponse, plus d'essaie
    else{
        $resultat = 'perdu ! passez à l\'enigme suivante';
        $afficheFormulaire = false;
    }
}

// affichage
?>

<h1>Un animal intelligent</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentatives.</p>

<p class="texte_stylé">Les profondeurs océaniques abritent des créatures fascinantes et mystérieuses. Parmi elles, un prédateur habile se distingue par sa capacité à changer de couleur et de texture pour se fondre dans son environnement. Grâce à cette capacité, il peut surprendre ses proies ou échapper à ses prédateurs. C'est un mollusque, et il est souvent considéré comme l'une des créatures marines les plus intelligentes.</p>

<img src="./enigmes/documents/enigme1.png">

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>


<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)?>" method="POST">
            
        <select name="response">
            <option value="1">1 - dragon bleu des mers</option>
            <option value="2">2 - hippocampe feuille</option>
            <option value="3">3 - poisson clown</option>
            <option value="4">4 - poulpe</option>
        </select>

        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
