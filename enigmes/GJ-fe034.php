<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ-fe034';

// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);

// initialisation des valeurs
if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] = '';
    UPDATEfichier($fichierTeam, $equipes);
}
if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage'] = 1;
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
    if($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['response'] == 3 ){

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

<h1>Faut pas faire bruler !</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">ATTENTION : vous avez droit à <?=$equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['comptage']?> tentatives.</p>

<p class="texte_stylé"> Lequel des matériaux suivants est le meilleur isolant pour contenir un feu ?</p>


<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>


<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)?>" method="POST">
            
        <select name="response">
            <option value="1">Métal</option>
            <option value="2">Bois</option>
            <option value="3">Laine minérale</option>
        </select>

        <input class="bout_action_stylé" type="submit">
    </form>

<?php 
    }
?>
