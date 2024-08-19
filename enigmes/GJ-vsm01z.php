<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'vsm01z';

// logique
testTeam();
$json = file_get_contents($fichierTeam);
$teams = json_decode($json, true);

// initialisation des valeurs
if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'])){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] = '';
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}
if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'])){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 3;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// insertion de la réponse + décompte
if( isset($_POST['response']) && $_POST['response'] !=''  &&  $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] > 0 ){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] = $_POST['response'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] -1 ;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// si l'equipe à déja proposé une réponse
if(isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['response']) && $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] != ''){
    if($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] == 4 ){

        // bonne réponse
        $resultat = 'Bonne réponse ! Votre équipe gagne 2 point !';
        $classResultat = 'resultat-green';
        $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 0;
        if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
            $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
            $teams[$_SESSION['equipe']]['score'] = $teams[$_SESSION['equipe']]['score']+2;
            $json = json_encode($teams, JSON_PRETTY_PRINT);
            file_put_contents($fichierTeam, $json);
        }
        $afficheFormulaire = false;
    }

    // mauvaise réponse, mais reste des essaies
    elseif ($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] >= 1) {
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

<h1>Identification des Espèces</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentatives.</p>

<p class="texte_stylé">Les profondeurs océaniques abritent des créatures fascinantes et mystérieuses. Parmi elles, un prédateur habile se distingue par sa capacité à changer de couleur et de texture pour se fondre dans son environnement. Grâce à cette capacité, il peut surprendre ses proies ou échapper à ses prédateurs. C'est un mollusque, et il est souvent considéré comme l'une des créatures marines les plus intelligentes.</p>

<img src="./enigmes/documents/enigme1.png">

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>


<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme("GJ-".$nomEpreuve)?>" method="POST">
            
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
