CONCEPT
Site web pour gérer des énigmes à créer et à résoudre par les enfants.
Ce projet web est utilisé par le centre de loisirs Le Petit Capitole à Toulouse.

UTILISATION
La page http://localhost/EnigmesPeca/?admin=xv25tr8 donne la liste complète des énigmes.
Le bouton "QR-code" permet de générer un QR-code redirigeant vers l'énigme en question.
Les adolescents et/ou les animateurs scannent le QR-code et ont accès à la page.

Selon la configuration des énigmes, il est possible de :
 . Créer des équipes
 . Mettre en place un système de points
 . Gérer automatiquement un tableau de scores
 . Organiser un jeu de piste
 . Mettre en place des énigmes simples
 . Mettre en place des énigmes à choix multiples
 . Limiter le nombre de tentatives pour résoudre les énigmes
 . Créer un système de compte d'administration (avec utilisateur + mot de passe)
 . Configurer une page d'administration pour gérer différents paramètres des énigmes

STRUCTURE
enigmes/    : contient la liste des pages conçues par les enfants
model/      : contient les fonctions utilitaires
SASS/       : contient les fichiers de style
structure/  : contient les fichiers principaux
index.php   : fichier principal

La structure est conçue de façon simple pour les enfants.
Pour créer une nouvelle page, il suffit de créer un nouveau fichier PHP dans le dossier "enigmes/".
Le contenu de la page est séparé en deux parties : la logique (partie PHP) et l'affichage (partie HTML).
Il est possible de copier/coller une page préexistante et de modifier son contenu afin de faciliter la conception.
Il est également possible d'ajouter des ressources à la page, comme des images, qui devront être placées dans le dossier "enigmes/documents/".

