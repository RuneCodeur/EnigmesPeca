<?php
//valeurs
$fichierUsers = './enigmes/documents/users.json'; // nom du fichier utilisé pour les utilisateurs
$resultat = '';
$affichageConnexion = 'flex';
$affichageEquipe = 'none';
$equipes = [];
$nomEpreuve = "GJ-DL";

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



//affichage
?>

<h1>QR-codes</h1>


<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
    <p>connexion</p>
    <input class="bout_stylé" type="text" id="pseudo" name="pseudo" placeholder="nom du compte" required>
    <input class="bout_stylé" type="password" id="password" name="password" placeholder="mot de passe" required>
    <input class="bout_action_stylé" type="submit">
</form>

<div style="display:<?=$affichageEquipe?>; min-width:190px;" class="liste-simple">
    <a href="./enigmes/documents/qrcodes.pdf" download="qrcodes.pdf">Télécharger le fichier</a>
</div>
