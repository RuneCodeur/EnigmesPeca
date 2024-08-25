<?php
//valeurs
$fichier = './enigmes/documents/stat.json';     // nom du fichier utilisé pour l'enregistrement
$resultat = '';
//logique
if(isset($_POST['nom']) && isset($_POST['score'])){     // si il y a un score ET un nom à enregistrer
    
    $stat = GETfichier($fichier);
    $stat[$_POST['nom']] = $_POST['score'];             // insère le score à rajouter avec un nom d'equipe (si le nom de l'equipe est déja utilisé, remplace son score) 
    UPDATEfichier($fichier, $stat);
    $resultat = 'score de "' . $_POST['nom'] . '" mis à jour !';
}

//affichage
?>

<h1>score de l'equipe</h1>

<p class="texte_stylé"> Donne le nom de ton équipe et son score</p>

<p class="resultat resultat-green">
    <?= $resultat ?>
</p>

<form class="formulaire_stylé" action="<?=lienEnigme("scoring")?>" method="POST">
    <input class="bout_stylé" type="text" id="nom" name="nom" placeholder="nom de l'équipe" required>
    <input class="bout_stylé" type="number" id="score" name="score" placeholder="score" min="0" max="10" value="0" required>
    <input class="bout_action_stylé" type="submit">
</form>

