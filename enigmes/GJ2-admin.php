<?php
// valeurs
$fichierTeam = './enigmes/documents/team-GJ2.json';
$fichierPara = './enigmes/documents/para-GJ2.json';
$fichierUsers = './enigmes/documents/users.json';
$resultat = '';
$affichageConnexion = 'flex';
$affichageEquipe = 'none';
$classResultat = 'resultat-red';
$equipes = null;
$ParaEpreuves = null;
$Users = null;
$selectFALSE = "";
$selectTRUE = "";
$nomEpreuve = 'GJ2-admin';

// logique
$ParaEpreuves = GETfichier($fichierPara);

// validation de la connexion
if(isset($_SESSION['admin-pseudo']) && isset($_SESSION['admin-pseudo'])){
    $_POST['pseudo'] = $_SESSION['admin-pseudo'];
    $_POST['password'] = $_SESSION['admin-password'];
}

if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $equipes = GETfichier($fichierTeam);
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


    // suppression de l'equipe
    if(isset($_GET['del'])){
        if (array_key_exists($_GET['del'], $equipes)) {
            unset($equipes[$_GET['del']]);
            UPDATEfichier($fichierTeam, $equipes);

            header('Location: '.lienEnigme($nomEpreuve));
            die;
        }
        else{
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

    // modification de l'affichage du score total
    if(isset($_POST['total'])){
        if($_POST['total'] == 0){
            $ParaEpreuves['total'] = false;
        }
        elseif ($_POST['total'] == 1) {
            $ParaEpreuves['total'] = true;
        }
        UPDATEfichier($fichierPara, $ParaEpreuves);
    }

    // modification du nombre total des épreuves
    if(isset($_POST["number"])){
        $ParaEpreuves['nb-epreuves'] = $_POST["number"];
        UPDATEfichier($fichierPara, $ParaEpreuves);
    }

    // modification d'une description d'une épreuve
    if(isset($_POST['description'])){
        $ParaEpreuves['epreuves'][$_GET['updateEpreuve']] = $_POST['description'];
        UPDATEfichier($fichierPara, $ParaEpreuves);
        header('Location: '.lienEnigme($nomEpreuve));
        die;
    }
}


if(isset($ParaEpreuves['total'])){
    if($ParaEpreuves['total'] == true){
        $selectTRUE = "selected";
    }
    if($ParaEpreuves['total'] == false){
        $selectFALSE = "selected";
    }
}

//affichage
?>

<h1>Paramètres ADMIN</h1>

<p class="resultat <?=$classResultat?>">
    <?= $resultat ?>
</p>

<form style="display:<?=$affichageConnexion?>" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
    <p>Connexion</p>
    <input class="bout_stylé" type="text" id="pseudo" name="pseudo" placeholder="nom du compte" required>
    <input class="bout_stylé" type="password" id="password" name="password" placeholder="mot de passe" required>
    <input class="bout_action_stylé" type="submit">
</form>

<div style="display:<?=$affichageEquipe?>;" class="bloc-colonne">

    <h2>équipes</h2>
    <ul style="; min-width:190px;" class="liste-simple">
        <?php
        foreach ($equipes as $nom => $value) {
            ?>
            <li>
                <p><?=$nom?> : </p>
                <form action="<?=lienEnigme($nomEpreuve)?>&del=<?=$nom?>" method="POST"><input type="submit" value = "supprimer"></form>
            </li>
            <?php
        }
        ?>
    </ul>

    <form style=" min-width:190px;" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        <input class="bout_stylé" type="text" name="newEquip" placeholder="nom d'équipe" required>
        <input class="bout_action_stylé" type="submit" value="création">
    </form>

    <br>

    <h2>épreuves</h2>
    <form style=" min-width:190px;" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        
        <label for="total">Score total</label>
        <select name="total">
            <option value="0" <?= $selectFALSE?>>non</option>
            <option value="1" <?= $selectTRUE?>>oui</option>
        </select>

        <label for="number">nombre d'épreuve total</label>
        <input type="number" name="number" value="<?=$ParaEpreuves['nb-epreuves']?>">
        <input class="bout_action_stylé" type="submit" value="modifier">
    </form>

    <ul style="; min-width:190px;" class="liste-style-1">
        <?php
        for ($i=1; $i <= $ParaEpreuves['nb-epreuves']; $i++) {
            $description = "";
            if(isset($ParaEpreuves['epreuves'][$i])){
                $description = $ParaEpreuves['epreuves'][$i];
            }
            ?>
            <li>
                <p>épreuve <?=$i?></p>
                <form action="<?=lienEnigme($nomEpreuve)?>&updateEpreuve=<?=$i?>" method="POST">
                    <textarea name="description"><?=$description?></textarea>
                    <input type="submit" value = "mettre à jour">
                </form>
            </li>
            <?php
        }
        ?>
    </ul>
</div>