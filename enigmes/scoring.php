<?php
//valeurs
$fichier = './enigmes/documents/stat.json';     // nom du fichier utilisé pour l'enregistrement

//logique
if(isset($_POST['nom']) && isset($_POST['score'])){     // si il y a un score ET un nom à enregistrer
    $json = file_get_contents($fichier);                // récupère le contenue du fichier 
    $stat = json_decode($json, true);                   // converti le contenue en un format utilisable
    $stat[$_POST['nom']] = $_POST['score'];             // insère le score à rajouter avec un nom d'equipe (si le nom de l'equipe est déja utilisé, remplace son score) 
    $json = json_encode($stat, JSON_PRETTY_PRINT);      // reconverti le contenue en un format utilisable par le fichier
    file_put_contents($fichier, $json);                 // met à jour le fichier utilisé
}

//affichage
?>

<h1>score de l'equipe</h1>

<p class="texte_stylé"> Donne le nom de ton équipe et son score</p>


<form class="formulaire_stylé" action="<?=lienEnigme("scoring")?>" method="POST">
    <input class="bout_stylé" type="text" id="nom" name="nom" placeholder="nom de l'équipe" required>
    <input class="bout_stylé" type="number" id="score" name="score" placeholder="score" min="0" max="10" value="0" required>
    <input class="bout_action_stylé" type="submit">
</form>

