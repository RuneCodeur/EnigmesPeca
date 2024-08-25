<?php
// valeurs
$fichierTeam = './enigmes/documents/team.json';
$resultat = '';
$classResultat = 'resultat-red'; 
$afficheFormulaire = true;
$nomEpreuve = 'hack';

// logique
testTeam($fichierTeam, "GJ-intro");
$equipes = GETfichier($fichierTeam);


if(!isset($equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'])){
    $equipes[$_SESSION['equipe']]['liste'][$nomEpreuve]['win'] = 1;
    $equipes[$_SESSION['equipe']]['score'] = $equipes[$_SESSION['equipe']]['score']-1;
    UPDATEfichier($fichierTeam, $equipes);
}

// affichage
?>

<h1>HACK EN COURS...</h1>

<p class="signature"> <?= $_SESSION['equipe'] ?></p>

<br>

<p class="texte_alerte">4L3rTE : SC0RE De L'3QuipE H4CK2D</p>

<p class="texte_alerte">VoTre 3qu1pe À peRdu 1 p0int</p>
