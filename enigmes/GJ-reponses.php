<?php
//valeurs
$fichierTeam = './enigmes/documents/team.json';     // nom du fichier utilisé pour l'enregistrement
$fichierUsers = './enigmes/documents/users.json'; // nom du fichier utilisé pour les utilisateurs
$resultat = '';
$affichageConnexion = 'flex';
$affichageEquipe = 'none';
$classResultat = 'resultat-red';                // par defaut, affiche le message en rouge
$equipes = [];
$nomEpreuve = 'reponses';

//logique

//validation de la connexion
if(isset($_SESSION['admin-pseudo']) && isset($_SESSION['admin-pseudo'])){
    $_POST['pseudo'] = $_SESSION['admin-pseudo'];
    $_POST['password'] = $_SESSION['admin-password'];
}

if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $Users = GETfichier($fichierUsers);
    $resultat = 'nom ou mot de passe invalide';
    if(isset($Users[$_POST['pseudo']])){
        if($Users[$_POST['pseudo']] == $_POST['password']){
            $_SESSION['admin-pseudo'] = $_POST['pseudo'];
            $_SESSION['admin-password'] = $_POST['password'];
            $affichageConnexion = 'none';
            $affichageEquipe = 'flex';
            $resultat = '';
        }
    }
}


// affichage des equipes
$equipes = GETfichier($fichierTeam);

//enlève 1 point à l'equipe
if(isset($_GET['down'])){
    $equipes[$_GET['down']]['score'] = $equipes[$_GET['down']]['score']-1;
    UPDATEfichier($fichierTeam, $equipes);
}

if(isset($_GET['up'])){
    $equipes[$_GET['up']]['score'] = $equipes[$_GET['up']]['score']+1;
    UPDATEfichier($fichierTeam, $equipes);
}

//affichage
?>

<h1>paramètres ADMIN</h1>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme("GJ-".$nomEpreuve)?>" method="POST">
    <p>connexion</p>
    <input class="bout_stylé" type="text" id="pseudo" name="pseudo" placeholder="nom du compte" required>
    <input class="bout_stylé" type="password" id="password" name="password" placeholder="mot de passe" required>
    <input class="bout_action_stylé" type="submit">
</form>

<ul style="display:<?=$affichageEquipe?>; min-width:190px;" class="liste-colonne">
    
    <li>
        <h2>météo</h2>
        <p><b>question facile :</b> Azote</p>
        <p><b>question moyenne :</b> La grêle</p>
        <p><b>question difficile :</b> 8</p>
    </li>
    
    <li>
        <h2>géologie</h2>
        <p><b>question facile :</b> diamant</p>
        <p><b>question moyenne :</b> image 2</p>
        <p><b>question difficile :</b> Restes préservées d'organismes anciens</p>
    </li>
    
    <li>
        <h2>chimie</h2>
        <p><b>question facile :</b> h2o</p>
        <p><b>question moyenne :</b> Hydrogène</p>
        <p><b>question difficile :</b> 24</p>
    </li>

    <li>
        <h2>feu</h2>
        <p><b>question facile :</b> 100</p>
        <p><b>question moyenne :</b> oxygène</p>
        <p><b>question difficile :</b> Laine minérale</p>
    </li>
</ul>