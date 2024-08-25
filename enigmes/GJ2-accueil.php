<?php
// valeurs
$fichierTeam = './enigmes/documents/team-GJ2.json';
$fichierPara = './enigmes/documents/para-GJ2.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'GJ2-accueil';
$ParaEpreuves = null;
$equipes = null;

$equipes = GETfichier($fichierTeam);
$ParaEpreuves = GETfichier($fichierPara);

// logique

if(isset($_GET['quit'])){
    session_destroy();
    header('Location: '.lienEnigme($nomEpreuve));
    die;
}

if(isset($_SESSION['equipe'])){
    testTeam($fichierTeam, "GJ2-accueil");
}

if (isset($_POST['selectEquip']) && $_POST['selectEquip'] !='') {
    
    if(isset($equipes[$_POST['selectEquip']])){
        $_SESSION['equipe'] = $_POST['selectEquip'];
    }
    else{
        $resultat = "Nom d'equipe déja pris !";
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

if(isset($_SESSION['equipe'])){
    $afficheFormulaire = false;
}

// affichage
?>

<h1>Score des epreuves</h1>


<?php
if($afficheFormulaire){
    ?>
    <p class="resultat <?=$classResultat?>">
        <?= $resultat ?>
    </p>
    

    <p> Avant de jouer, choisissez votre équipe !</p>

    <form class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        
        <select name="selectEquip">
        <?php
        foreach ($equipes as $nom => $value) {
            ?>
            <option value="<?=$nom?>"><?=$nom?></option>
            <?php
        }
        ?>
        </select>

        <input class="bout_action_stylé" type="submit">
    </form>

    <br>
    
    <p> Ou alors, ajoute ton nom d'équipe !</p>

    <form style=" min-width:190px;" class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>" method="POST">
        <input class="bout_stylé" type="text" name="newEquip" placeholder="nom d'équipe" required>
        <input class="bout_action_stylé" type="submit" value="création">
    </form>

    <?php 
    }else{
        ?>

        <p class="signature"> <?= $_SESSION['equipe'] ?></p>

        
        <nav>
            <p >accueil</p>
            <?php
            for ($i=1; $i <= $ParaEpreuves['nb-epreuves']; $i++) {  
                ?>

                <a href="<?=lienEnigme("GJ2-epreuve")."&epreuve=".$i?>">épreuve <?=$i?></a>

                <?php
            }
            ?>

        </nav>
        
        <div class="table_stylé">
            <table >
                <thead>
                    <tr>
                        <th> équipe </th>
                        <?php 
                        for ($i=1; $i <= $ParaEpreuves['nb-epreuves']; $i++) { 
                        ?>

                        <th> épreuve <?=$i?></th>

                        <?php
                        }
                        if($ParaEpreuves['total'] == true){
                            ?>

                            <th>TOTAL</th>

                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                    <tbody>
                        <?php 
                            foreach ($equipes as $equipe => $value) {
                                $scoreTotal = 0;
                            ?>

                            <tr>
                                <td> <?=$equipe?> </td>
                                <?php 
                                for ($i=1; $i <= $ParaEpreuves['nb-epreuves']; $i++) { 
                                    $score = null;
                                    if(isset($value['liste'][$i])){
                                        $score = $value['liste'][$i];
                                        $scoreTotal += $value['liste'][$i];
                                    }
                                    ?>

                                    <th><?=$score?></th>

                                    <?php
                                }
                                if($ParaEpreuves['total'] == true){
                                    ?>

                                    <th><?=$scoreTotal?></th>

                                    <?php
                                }
                                 ?>
                            </tr>

                            <?php
                            }
                        ?>


                        
                </tbody>
            </table>
        </div>

        <form class="formulaire_stylé" action="<?=lienEnigme($nomEpreuve)?>&quit" method="POST">
            <input class="bout_action_stylé" type="submit" value="Quitter l'équipe">
        </form>

    <?php
    }
?>
