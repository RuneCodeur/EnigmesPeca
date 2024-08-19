<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;

$json = file_get_contents($fichierTeam);
$equipes = json_decode($json, true);

// logique

if(isset($_GET['quit'])){
    session_destroy();
    header('Location: '.lienEnigme("GJ-intro"));
    die;
}

if (isset($_POST['newEquip']) && $_POST['newEquip'] !='') {
    
    if (preg_match('/[^a-zA-Z0-9-]/', $_POST['newEquip'])) {
        $resultat = "caractères non autorisé !";
    }
    elseif(isset($equipes[strtolower($_POST['newEquip'])])){
        $resultat = "Nom d'equipe déja pris !";
    }
    else{
        $equipes[$_POST['newEquip']] = [
            'score' => 0,
            'liste' => [],
        ];

        $json = json_encode($equipes, JSON_PRETTY_PRINT);
        file_put_contents($fichierTeam, $json);
        $_SESSION['equipe'] = $_POST['newEquip'];
    }
}


if (isset($_POST['selectEquip']) && $_POST['selectEquip'] !='') {
    
    if(isset($equipes[$_POST['selectEquip']])){
        $_SESSION['equipe'] = $_POST['selectEquip'];
    }
    else{
        $resultat = "Nom d'equipe déja pris !";
    }
}

if(isset($_SESSION['equipe'])){
    $afficheFormulaire = false;
    $resultat = "Vous faites parti de l'equipe : " . $_SESSION['equipe'];
    $classResultat = 'resultat-green';
}

// affichage
?>

<h1>introduction</h1>

<p class="texte_stylé"> TEXTE D'INTRODUCTION AU GRAND JEU</p>
<br>

<p class="texte_stylé"> Avant de jouer, choisissez un nom pour votre équipe. Uniquement des lettres majuscules, minuscules, des chiffres et des tiret "-"</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <form class="formulaire_stylé" action="<?=lienEnigme("GJ-intro")?>" method="POST">
        <input class="bout_stylé" type="text" name="newEquip" placeholder="nom d'équipe">
        <input class="bout_action_stylé" type="submit">
    </form>

    <p>Ou alors, choisissez une équipe déja créée</p>

    <form class="formulaire_stylé" action="<?=lienEnigme("GJ-intro")?>" method="POST">
        
        <select name="selectEquip">
        <?php
        foreach ($equipes as $nom => $value) {
            ?>
            <option value="<?=$nom?>"><?=$nom?></option>
            <?php
        }
        ?>
        </select>

        <input class="bout_action_stylé" type="submit">
    </form>

    <?php 
    }else{
        ?>
    <form class="formulaire_stylé" action="<?=lienEnigme("GJ-intro")?>&quit" method="POST">
        <input class="bout_action_stylé" type="submit" value="Quitter l'équipe">
    </form>


<?php
    }
?>
