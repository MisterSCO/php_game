<?php
// Gestion (et démarrage) des sessions PHP
session_start();
//session_destroy();

// Affichage des erreurs PHP (à ne pas faire en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auto-chargement des classes
// > on défini une fonction anonyme à appeler en cas d'erreur
spl_autoload_register(function ($sNamespaceClass) {
  $sConvertedClass = str_replace('\\', '/', $sNamespaceClass);
  include_once($sConvertedClass.'.php');
});

// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
// On récupère le joueur en session (si existant)
$oPlayer = isset($_SESSION['player']) ? unserialize($_SESSION['player']) : null;

if (isset($_GET['new'])) {
    $oPlayer = new Entity\Player('F2000');
    $oCharacter = new Model\Warrior('Aragorn');
    
    // Liaisons Player-Character / Character-Player
    $oPlayer->setCharacter($oCharacter);
    $oCharacter->setPlayer($oPlayer);

    // Créer un plateau de jeu
    $oGame = new Model\RpgGame();
    $oGame->addPlayer($oPlayer);
    $oGame->fillBoard();

    // On enregistre le jeu en session
    $_SESSION['game'] = serialize($oGame);

    // On enregistre le joueur en session
    $_SESSION['player'] = serialize($oPlayer);

    header('Location: index.php');
}

$aGameInfo = [];
if ($oGame && $oPlayer) {
    if (isset($_GET['x']) && isset($_GET['y'])) {
        // 2. Action sur le plateau de jeu
        $aGameInfo = $oGame->selectCell($oPlayer, $_GET['x'], $_GET['y']);
    }

    // On enregistre le jeu "modifié" en session
    $_SESSION['game'] = serialize($oGame);
    $_SESSION['player'] = serialize($oPlayer);
    
    if (isset($_GET['x']) && isset($_GET['y'])) {
        include('templates/board.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="styles.css" />

    <title>RpgGame</title>
  </head>
  <body class="text-center">
    <h1>RpgGame</h1>

    <a href="?new" class="btn btn-primary my-3">Nouvelle partie</a><br />

    <div class="container">
        <?php if ($oGame): ?>
            <div id="board">
                <?php include('templates/board.php'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('keydown', function(e) {
            e.preventDefault();
        });

        $(document).on('keyup', function(e) {
            let $pawnContainer = $('.pawn').parent();       // document.querySelector('.pawn').parentNode()
            let x = $pawnContainer.data('x');               // $pawnContainer.getAttribute('data-x')
            let y = $pawnContainer.data('y');               // $pawnContainer.getAttribute('data-y')

            switch (e.keyCode) {
                case 37:    // Left
                    x--;
                    break;

                case 38:    // Up
                    y--;
                    break;
                    
                case 39:    // Right
                    x++;
                    break;
                    
                case 40:    // Down
                    y++;
                    break;
            }

            if ([37, 38, 39, 40].includes(e.keyCode)) {
                let $cell = $('.cell[data-x='+ x +'].cell[data-y='+ y +']'); 
                // document.querySelector('.cell[data-x='+ x +'][data-y='+ y +']')
                if ($cell) {
                    $cell.click();      // $cell.trigger('click')
                }
            }
        });

        // Live event : on écoute le "click" tous les élements ".cell" contenus dans #board
        $('#board').on('click', '.cell', function() {
            // this = objet courant (Javascript)
            // $(this) = encapsulation jQuery de l'objet courant

            let x = $(this).data('x');
            let y = $(this).data('y');

            // AJAX - Requête GET (permet de mettre à jour une partie de la page)
            $.get('index.php?x='+ x + '&y='+ y, function(data, status) {
                $('#board').html(data);
            });
        });
    </script>
  </body>
</html>
