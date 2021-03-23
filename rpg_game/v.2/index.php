<?php
include('_bootstrap.php');
// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
// On récupère le joueur en session (si existant)
$oPlayer = isset($_SESSION['player']) ? unserialize($_SESSION['player']) : null;

var_dump($oPlayer);
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

    <div id="NewGame" class="btn btn-primary my-3">Nouvelle partie</div><br />

    
    <div class="container">
        <div id="board">
            <?php if ($oGame) : ?>
                <?php include('templates/board.php'); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function refreshBoard(params) {
            $.get('api.php?' + params, function(data) {
                $('#board').html(data);
            });
        }

        $(document).ready(function() {
            $(document).on('keydown', function(e) {
                e.preventDefault();
            });

            $(document).on('keyup', function(e) {
                let $pawnContainer = $('.pawn').parent(); // document.querySelector('.pawn').parentNode()
                let x = $pawnContainer.data('x'); // $pawnContainer.getAttribute('data-x')
                let y = $pawnContainer.data('y'); // $pawnContainer.getAttribute('data-y')

                switch (e.keyCode) {
                    case 37: // Left
                        x--;
                        break;

                    case 38: // Up
                        y--;
                        break;

                    case 39: // Right
                        x++;
                        break;

                    case 40: // Down
                        y++;
                        break;
                }

                if ([37, 38, 39, 40].includes(e.keyCode)) {
                    let $cell = $('.cell[data-x=' + x + '].cell[data-y=' + y + ']');
                    // document.querySelector('.cell[data-x='+ x +'][data-y='+ y +']')
                    if ($cell) {
                        $cell.click(); // $cell.trigger('click')
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

                refreshBoard('x=' + x + '&y=' + y);
            });

            setInterval(function() {

                refreshBoard('refresh');

            }, 3000);

            $('#NewGame').on('click', function() {
                // AJAX - Requête GET (permet de mettre à jour une partie de la page)
                refreshBoard('new');
            });

        })
    </script>
</body>

</html>