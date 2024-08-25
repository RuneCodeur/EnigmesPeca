<?php
// valeurs
$fichierTeam = './enigmes/documents/team-GJ2.json';
$fichierPara = './enigmes/documents/para-GJ2.json';
$resultat = '';
$classResultat = 'resultat-red';
$nomEpreuve = 'GJ2-epreuve';
$ParaEpreuves = null;
$equipes = null;
$score = 0;

$idEpreuve = 0;
$description = '';


// logique

testTeam($fichierTeam, "GJ2-accueil");

if(isset($_GET['epreuve'])){
    $idEpreuve = $_GET['epreuve'];
}else{
    header('Location: '.lienEnigme("GJ2-accueil"));
    die;
}

$ParaEpreuves = GETfichier($fichierPara);
$equipes = GETfichier($fichierTeam);

if(isset($ParaEpreuves['epreuves'][$idEpreuve])){
    $description = $ParaEpreuves['epreuves'][$idEpreuve];
}

// insertion de la réponse
if( isset($_POST['response']) && $_POST['response'] !='' ){
    $equipes[$_SESSION['equipe']]['liste'][$idEpreuve] = $_POST['response'];
    UPDATEfichier($fichierTeam, $equipes);
}

// si l'equipe à déja marqué des points -> affiche le score
if(isset($equipes[$_SESSION['equipe']]['liste'][$idEpreuve])){
    $score = $equipes[$_SESSION['equipe']]['liste'][$idEpreuve];
    $resultat = "votre équipe à déja ".$score. " points sur cette épreuve !";
    $classResultat = 'resultat-green';
}

// affichage
?>

<h1>Epreuve <?=$idEpreuve?></h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>


<nav>
    <a href="<?=lienEnigme("GJ2-accueil")?>">accueil</a>
    <?php
    for ($i=1; $i <= $ParaEpreuves['nb-epreuves']; $i++) {  
        if($i != $idEpreuve){
            ?>

            <a href="<?=lienEnigme("GJ2-epreuve")."&epreuve=".$i?>">épreuve <?=$i?></a>

            <?php  
        }else{
            ?>

            <p>épreuve <?=$i?></p>

            <?php
        }
    }
    ?>

</nav>

<p class="texte_stylé"><?=$description?></p>


<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>



<form class="formulaire_stylé"  action="<?=lienEnigme($nomEpreuve)."&epreuve=".$idEpreuve?>" method="POST">
    <input type="number" name="response" value="<?=$score?>" min="0" required>
    <input class="bout_action_stylé" type="submit" value="Valider">
</form>

