<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ-vsm03r';

// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);

// initialisation des valeurs
if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] = 0;
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal2'] = 0;
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal3'] = 0;
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal4'] = 0;
    UPDATEfichier($fichierTeam, $equipes);
}
if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 1;
    UPDATEfichier($fichierTeam, $equipes);
}

// insertion de la réponse + décompte
if( isset($_POST['animal1']) && $_POST['animal1'] !=''  &&  $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] > 0 ){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] = $_POST['animal1'];
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal2'] = $_POST['animal2'];
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal3'] = $_POST['animal3'];
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal4'] = $_POST['animal4'];
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] -1 ;
    UPDATEfichier($fichierTeam, $equipes);
}

// si l'equipe à déja proposé une réponse
if(isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1']) && $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] != 0){
    if($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal1'] == 2 &&
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal2'] == 1 &&
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal3'] == 3 &&
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['animal4'] == 2
    ){

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

<h1>Chaine Alimentaire !</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentative.</p>

<p class="texte_stylé">Votre mission est d'organiser les animaux marins dans l'ordre correct de la chaîne alimentaire, du producteur primaire au super-prédateur. Utilisez les listes déroulantes ci-dessous pour placer chaque animal à sa place correcte dans la chaîne alimentaire.</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)?>" method="POST">
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
