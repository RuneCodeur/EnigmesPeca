<?php
//valeurs
$fichierTeam = './enigmes/documents/team.json';     // nom du fichier utilisé pour l'enregistrement
$fichierUsers = './enigmes/documents/users.json'; // nom du fichier utilisé pour les utilisateurs
$resultat = '';
$affichageConnexion = 'flex';
$affichageEquipe = 'none';
$classResultat = 'resultat-red';                // par defaut, affiche le message en rouge
$equipes = [];

//logique

//validation de la connexion
if(isset($_SESSION['admin-pseudo']) && isset($_SESSION['admin-pseudo'])){
    $_POST['pseudo'] = $_SESSION['admin-pseudo'];
    $_POST['password'] = $_SESSION['admin-password'];
}

// affichage des equipes
$equipes = GETfichier($fichierTeam);


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

    //enlève 1 point à l'equipe
    if(isset($_GET['down'])){
        $equipes[$_GET['down']]['score'] = $equipes[$_GET['down']]['score']-1;
        UPDATEfichier($fichierTeam, $equipes);
        header('Location: '.lienEnigme("GJ-equipes"));
        die;
    }

    //ajoute 1 point a l'equipe
    if(isset($_GET['up'])){
        $equipes[$_GET['up']]['score'] = $equipes[$_GET['up']]['score']+1;
        UPDATEfichier($fichierTeam, $equipes);
        header('Location: '.lienEnigme("GJ-equipes"));
        die;
    }

}



//affichage
?>

<h1>Equipes</h1>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<ul style="min-width:190px;" class="liste-simple">
    <?php
    foreach ($equipes as $nom => $value) {
        ?>
        <li>
            <p><?=$nom?> : </p>
            <b>
                <form style="display:<?=$affichageEquipe?>;" action="<?=lienEnigme("GJ-equipes")?>&down=<?=$nom?>" method="POST"><input class="ball" type="submit" value = "-"></form>
                <?=$value['score']?>
                <form style="display:<?=$affichageEquipe?>;" action="<?=lienEnigme("GJ-equipes")?>&up=<?=$nom?>" method="POST"><input class="ball" type="submit" value = "+"></form>
            </b>
        </li>
        <?php
    }
    ?>
</ul>
<br>
<br>
<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme("GJ-equipes")?>" method="POST">
    <p>connexion admin</p>
    <input class="bout_stylé" type="text" id="pseudo" name="pseudo" placeholder="nom du compte" required>
    <input class="bout_stylé" type="password" id="password" name="password" placeholder="mot de passe" required>
    <input class="bout_action_stylé" type="submit">
</form>