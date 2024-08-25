<?php
    $content = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enigmes Peca</title>
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <main>
        <?= $content ?>
    </main>
    
    <footer>
        <p>Enigmes du Petit Capitole de Toulouse <br> 2024 - Tous droits réservés</p>
    </footer>
</body>
</html>