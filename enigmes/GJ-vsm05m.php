<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'vsm05m';

// logique
testTeam();
$json = file_get_contents($fichierTeam);
$teams = json_decode($json, true);

// initialisation des valeurs
if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques1'])){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques1'] = 0;
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques2'] = 0;
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques3'] = 0;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}
if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'])){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 1;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// insertion de la réponse + décompte
if( isset($_POST['ques1']) && $_POST['ques1'] !=''  &&  $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] > 0 ){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques1'] = $_POST['ques1'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques2'] = $_POST['ques2'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques3'] = $_POST['ques3'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] -1 ;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// si l'equipe à déja proposé une réponse
if(isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques1']) && $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques1'] != 0){
    if($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques1'] == 3 &&
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques2'] == 4 &&
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['ques3'] == 2
    ){

        // bonne réponse
        $resultat = 'Bonne réponse ! Votre équipe gagne 3 point !';
        $classResultat = 'resultat-green';
        $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 0;
        if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
            $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
            $teams[$_SESSION['equipe']]['score'] = $teams[$_SESSION['equipe']]['score']+3;
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

<h1>Questions HARDCORE</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentative.</p>

<p class="texte_stylé">Répondez à toutes les questions en même temps !</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme("GJ-".$nomEpreuve)?>" method="POST">
        <label for="ques1">Quel est le plus grand invertébré marin en termes de masse corporelle ?</label>
        <select name="ques1">
            <option value="1">La méduse à crinière de lion</option>
            <option value="2">Le poulpe géant du Pacifique</option>
            <option value="3">Le calmar géant</option>
            <option value="4">Le concombre de mer géant</option>
        </select>
        <br>

        <label for="ques2">Quel poisson est connu pour sa capacité à produire de la lumière à travers des organes appelés photophores ?</label>
        <select name="ques2">
            <option value="1">Le poisson-scie</option>
            <option value="2">Le poisson-ange</option>
            <option value="3">Le poisson-pierre</option>
            <option value="4">Le poisson-lanterne</option>
        </select>
        <br>

        <label for="ques3">Quelle espèce de requin est capable de régénérer ses dents tout au long de sa vie ?</label>
        <select name="ques3">
            <option value="1">Le requin-marteau</option>
            <option value="2">Le requin tigre</option>
            <option value="3">Le requin-baleine</option>
            <option value="4">Le requin blanc</option>
        </select>
        <br>

        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
