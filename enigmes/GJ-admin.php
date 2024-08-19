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

if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $json = file_get_contents($fichierUsers);                   // récupère les utilisateurs
    $Users = json_decode($json, true);                          // converti le contenue en un format utilisable
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
$json = file_get_contents($fichierTeam);
$equipes = json_decode($json, true);

//enlève 1 point à l'equipe
if(isset($_GET['down'])){
    $equipes[$_GET['down']]['score'] = $equipes[$_GET['down']]['score']-1;
    $json = json_encode($equipes, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

if(isset($_GET['up'])){
    $equipes[$_GET['up']]['score'] = $equipes[$_GET['up']]['score']+1;
    $json = json_encode($equipes, JSON_PRETTY_PRINT);
    file_put_contents($fichierTeam, $json);
}

// suppression de l'equipe
if(isset($_GET['del'])){
    if (array_key_exists($_GET['del'], $equipes)) {
        unset($equipes[$_GET['del']]);
        $json = json_encode($equipes, JSON_PRETTY_PRINT);
        file_put_contents($fichierTeam, $json);
        $classResultat = 'resultat-green';
        $resultat = 'Equipe "'.$_GET['del'].'" suprimé !';
    }else{
        $resultat = 'Equipe "'.$_GET['del'].'" inconnu.';
    }
}

//affichage
?>

<h1>paramètres ADMIN</h1>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme("GJ-admin")?>" method="POST">
    <p>connexion</p>
    <input class="bout_stylé" type="text" id="pseudo" name="pseudo" placeholder="nom du compte" required>
    <input class="bout_stylé" type="password" id="password" name="password" placeholder="mot de passe" required>
    <input class="bout_action_stylé" type="submit">
</form>

<ul style="display:<?=$affichageEquipe?>; min-width:190px;" class="liste-simple">
    <?php
    foreach ($equipes as $nom => $value) {
        ?>
        <li>
            <p><?=$nom?> : </p>
            <b>
                <form action="<?=lienEnigme("GJ-admin")?>&down=<?=$nom?>" method="POST"><input class="ball" type="submit" value = "-"></form>
                <?=$value['score']?>
                <form action="<?=lienEnigme("GJ-admin")?>&up=<?=$nom?>" method="POST"><input class="ball" type="submit" value = "+"></form>
            </b>
            <form action="<?=lienEnigme("GJ-admin")?>&del=<?=$nom?>" method="POST"><input type="submit" value = "supprimer"></form>
        </li>
        <?php
    }
    ?>
</ul>