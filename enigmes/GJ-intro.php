<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;

$equipes = GETfichier($fichierTeam);

// logique

if(isset($_GET['quit'])){
    session_destroy();
    header('Location: '.lienEnigme("GJ-intro"));
    die;
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

<p class="texte_stylé"> Quizz ultime des scientifiques !</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<?php
if($afficheFormulaire){
    ?>

    <p> Avant de jouer, choisissez votre équipe !</p>

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
