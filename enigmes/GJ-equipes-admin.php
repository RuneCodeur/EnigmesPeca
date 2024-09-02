<?php
//valeurs
$fichierTeam = './enigmes/documents/team.json';     // nom du fichier utilisé pour l'enregistrement
$fichierUsers = './enigmes/documents/users.json'; // nom du fichier utilisé pour les utilisateurs
$resultat = '';
$affichageConnexion = 'flex';
$affichageEquipe = 'none';
$classResultat = 'resultat-red';                // par defaut, affiche le message en rouge
$equipes = [];
$nomEpreuve = "GJ-equipes-admin";

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


    // affichage des equipes
    $equipes = GETfichier($fichierTeam);

    //enlève 1 point à l'equipe
    if(isset($_GET['down'])){
        $equipes[$_GET['down']]['score'] = $equipes[$_GET['down']]['score']-1;
        UPDATEfichier($fichierTeam, $equipes);
        header('Location: '.lienEnigme($nomEpreuve));
        die;
    }

    if(isset($_GET['up'])){
        $equipes[$_GET['up']]['score'] = $equipes[$_GET['up']]['score']+1;
        UPDATEfichier($fichierTeam, $equipes);
        header('Location: '.lienEnigme($nomEpreuve));
        die;
    }

    // suppression de l'equipe
    if(isset($_GET['del'])){
        if (array_key_exists($_GET['del'], $equipes)) {
            unset($equipes[$_GET['del']]);
            UPDATEfichier($fichierTeam, $equipes);
            $classResultat = 'resultat-green';
            header('Location: '.lienEnigme($nomEpreuve));
            die;
        }else{
            $resultat = 'Equipe "'.$_GET['del'].'" inconnu.';
        }
    }

    // création d'une equipe
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

            UPDATEfichier($fichierTeam, $equipes);
            $_SESSION['equipe'] = $_POST['newEquip'];
        }
    }
}



//affichage
?>

<h1>paramètres ADMIN</h1>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
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
                <form action="<?=lienEnigme($nomEpreuve)?>&down=<?=$nom?>" method="POST"><input class="ball" type="submit" value = "-"></form>
                <?=$value['score']?>
                <form action="<?=lienEnigme($nomEpreuve)?>&up=<?=$nom?>" method="POST"><input class="ball" type="submit" value = "+"></form>
            </b>
            <form action="<?=lienEnigme($nomEpreuve)?>&del=<?=$nom?>" method="POST"><input type="submit" value = "supprimer"></form>
        </li>
        <?php
    }
    ?>
</ul>

<form style="display:<?=$affichageEquipe?>; min-width:190px;" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
    <input class="bout_stylé" type="text" name="newEquip" placeholder="nom d'équipe" required>
    <input class="bout_action_stylé" type="submit" value="création">
</form>