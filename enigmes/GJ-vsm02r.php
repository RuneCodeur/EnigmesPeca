<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'vsm02r';

// logique
testTeam();
$json = file_get_contents($fichierTeam);
$teams = json_decode($json, true);

// initialisation des valeurs
if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'])){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] = 0;
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal2'] = 0;
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal3'] = 0;
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal4'] = 0;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}
if(!isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'])){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 1;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// insertion de la réponse + décompte
if( isset($_POST['animal1']) && $_POST['animal1'] !=''  &&  $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] > 0 ){
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] = $_POST['animal1'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal2'] = $_POST['animal2'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal3'] = $_POST['animal3'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal4'] = $_POST['animal4'];
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] -1 ;
    $json = json_encode($teams, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// si l'equipe à déja proposé une réponse
if(isset($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1']) && $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] != 0){
    if($teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] == 2 &&
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal2'] == 1 &&
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal3'] == 3 &&
    $teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal4'] == 2
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

<h1>Chaîne Alimentaire</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$teams[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentative.</p>

<p class="texte_stylé">Votre mission est d'organiser les animaux marins dans l'ordre correct de la chaîne alimentaire, du producteur primaire au super-prédateur. Utilisez les listes déroulantes ci-dessous pour placer chaque animal à sa place correcte dans la chaîne alimentaire.</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme("GJ-".$nomEpreuve)?>" method="POST">
        <label for="animal1">Producteur Primaire:</label>
        <select name="animal1">
            <option value="1">méduse</option>
            <option value="2">algues</option>
            <option value="3">Anchois</option>
        </select>
        <br>

        <label for="animal2">Herbivore:</label>
        <select name="animal2">
            <option value="1">crevettes</option>
            <option value="2">Murène</option>
            <option value="3">Coraux</option>
        </select>
        <br>

        <label for="animal3">Carnivore:</label>
        <select name="animal3">
            <option value="1">méduse</option>
            <option value="2">crabe</option>
            <option value="3">Thon</option>
        </select>
        <br>

        <label for="animal4">Super-Prédateur:</label>
        <select name="animal4">
            <option value="1">Raie Manta</option>
            <option value="2">grand requin blanc</option>
            <option value="3">Requin-pelerin</option>
        </select>
        <br>

        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
