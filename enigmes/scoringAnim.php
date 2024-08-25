<?php
//valeurs
$fichier = './enigmes/documents/stat.json';     // nom du fichier utilisé pour l'enregistrement
$listeUsers = './enigmes/documents/users.json'; // nom du fichier utilisé pour les utilisateurs
$resultat = '';
$affichageConnexion = 'flex';
$affichageFormulaire = 'none';
$classResultat = 'resultat-red';                // par defaut, affiche le message en rouge

//logique

//validation de la connexion
if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $Users = GETfichier($listeUsers);
    $resultat = 'nom ou mot de passe invalide';
    if(isset($Users[$_POST['pseudo']])){
        if($Users[$_POST['pseudo']] == $_POST['password']){
            $affichageConnexion = 'none';
            $affichageFormulaire = 'flex';
            $classResultat = 'resultat-green';
            $resultat = 'connexion validé !';
        }

    }
    
}

// inscription
if(isset($_POST['nom']) && isset($_POST['score'])){     // si il y a un score ET un nom à enregistrer
    $stat = GETfichier($fichier);
    $stat[$_POST['nom']] = $_POST['score'];             // insère le score à rajouter avec un nom d'equipe (si le nom de l'equipe est déja utilisé, remplace son score) 
    UPDATEfichier($fichier, $stat);
    $resultat = 'score de "' . $_POST['nom'] . '" mis à jour !';
}

//affichage
?>

<h1>score de l'equipe protégé </h1>

<p class="texte_stylé"> connecte toi avant de rentrer le score de ton equipe</p>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme("scoringAnim")?>" method="POST">
    <p>connexion</p>
    <input class="bout_stylé" type="text" id="pseudo" name="pseudo" placeholder="nom du compte" required>
    <input class="bout_stylé" type="password" id="password" name="password" placeholder="mot de passe" required>
    <input class="bout_action_stylé" type="submit">
</form>

<form style="display:<?=$affichageFormulaire?>" class="formulaire_stylé" action="<?=lienEnigme("scoring")?>" method="POST">
    <input class="bout_stylé" type="text" id="nom" name="nom" placeholder="nom de l'équipe" required>
    <input class="bout_stylé" type="number" id="score" name="score" placeholder="score" min="0" max="10" value="0" required>
    <input class="bout_action_stylé" type="submit">
</form>

