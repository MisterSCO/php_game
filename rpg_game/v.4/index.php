<?php

use Model\RpgGame;

include('_bootstrap.php');

// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
// Permet d'avoir la version actualisée/officielle de mon joueur
// (0 = arbitraire car jeu soloe)
$oPlayer = $oGame && count($oGame->getPlayers()) > 0 ? $oGame->getPlayers()[0] : null;

if (!$oGame instanceof RpgGame || ($oPlayer && $oPlayer->getCharacter()->isDead())) {

    // Créer un plateau de jeu
    $oGame = new Model\RpgGame();
    $oGame->fillBoard();

    // On enregistre le jeu en session
    $_SESSION['game'] = serialize($oGame);
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

    <div class="text-center">
        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#NewPlayerModal">
            Création du personnage
        </button>
    </div>

    <div class="container">
        <div id="board">
            <?php
            if ($oGame) {
                include('templates/board.php');
            }
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="NewPlayerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Création joueur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label>Nom du joueur</label>
                        </div>
                        <div class="col">
                            <input id="PlayerName" class="form-control" required />
                        </div>
                        <div class="col-auto">
                            <button id="PlayerGo" type="button" class="btn btn-info">GO !</button>
                        </div>
                    </div>
                    <hr class="w-50 mx-auto" />
                    <div id="ChoosePlayer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary disabled">Valider le personnage</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var $modalNewPlayer = $('#NewPlayerModal');

        /**
         * Requête AJAX en GET (permet de mettre à jour une partie de la page)
         * 
         * @param {string} params
         * @return void
         */
        function refreshBoard(params) {
            $.get('api.php?' + params, function(data) {
                $('#board').html(data);
            });
        }

        /**
         * Requête AJAX en GET (permet de mettre à jour une partie de la page)
         * 
         * @param {string} params
         * @return void
         */
        function refreshChoosePlayer(params) {
            $.get('api.php?' + params, function(data) {
                $('#ChoosePlayer').html(data);
            });
        }

        function checkChoosePlayerValidity() {
            var sPlayerName = $('#PlayerName').val();
            var sCharacterName = $('#CharacterName').val();

            $bIsInvalid = (sPlayerName === '') || (sCharacterName === '') || $('.player-type.active').length <= 0;
            $modalNewPlayer.find('.btn-primary').toggleClass('disabled', $bIsInvalid);
        }

        // Permettre d'être sûr que la page est chargée (éléments DOM)
        $(document).ready(function() {
            $(document).on('keydown', function(e) {
                if ([32, 37, 38, 39, 40].includes(e.keyCode)) {
                    e.preventDefault();
                }
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

                    case 32: // Space
                        // Effect "attack-around"
                        let $aroundCells = $();
                        for (var i = 1; i < 3; i++) {
                            $aroundCells = $aroundCells.add($('.cell[data-x=' + (x - i) + '][data-y=' + (y - i) + '], .cell[data-x=' + x + '][data-y=' + (y - i) + '], .cell[data-x=' + (x + i) + '][data-y=' + (y - i) + '], .cell[data-x=' + (x - i) + '][data-y=' + y + '], .cell[data-x=' + (x + i) + '][data-y=' + y + '], .cell[data-x=' + (x - i) + '][data-y=' + (y + i) + '], .cell[data-x=' + x + '][data-y=' + (y + i) + '], .cell[data-x=' + (x + i) + '][data-y=' + (y + i) + ']'));
                        }

                        $aroundCells.each(function() {
                            var $cell = $(this);

                            // Si une animation est déjà en cours on sort
                            if ($cell.data('attack-in-progress')) {
                                return;
                            }

                            $cell.data('attack-in-progress', true).data('backup', $cell.html()).html('&#128165;');
                            setTimeout(function() {
                                $cell.html($cell.data('backup')).data('attack-in-progress', false);
                            }, 500);
                        });

                        setTimeout(function() {
                            refreshBoard('action=attack');
                        }, 500);
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

                // AJAX - Requête GET
                refreshBoard('action=select&x=' + x + '&y=' + y);
            });

            // Création d'une partie
            $('#NewGame').on('click', function() {
                refreshBoard('new');
            });

            // Rafraichissement plateau
            setInterval(function() {
                refreshBoard('action=refresh');
            }, 3000);

            // Création du joueur/personnage
            $modalNewPlayer.find('#PlayerGo').on('click', function() {
                var sPlayerName = $('#PlayerName').val();
                if (sPlayerName === '') {
                    return;
                }

                refreshChoosePlayer('action=create_player&player_name=' + sPlayerName);
            });
            $modalNewPlayer.on('click', '.player-type', function() {
                var sPlayerName = $('#PlayerName').val();
                if (sPlayerName === '') {
                    return;
                }

                var sCharacterName = $('#CharacterName').val();
                var sCharacterClass = $(this).data('class');

                $('.player-type').removeClass('active');
                $(this).addClass('active');

                refreshChoosePlayer('action=create_player&player_name=' + sPlayerName + '&character_name=' + sCharacterName + '&class=' + sCharacterClass);

                setTimeout(checkChoosePlayerValidity, 500);
            });
            $modalNewPlayer.on('change', '#CharacterName', checkChoosePlayerValidity);
            $modalNewPlayer.find('.btn-primary').on('click', function() {
                var sPlayerName = $('#PlayerName').val();
                if (sPlayerName === '') {
                    return;
                }

                var sCharacterName = $('#CharacterName').val();
                if (sCharacterName === '') {
                    return;
                }

                var sPlayerClass = $('.player-type.active').data('class');


                refreshChoosePlayer('action=create_player&player_name=' + sPlayerName + '&class=' + sPlayerClass + '&character_name=' + sCharacterName + '&save=1');

                $(".btn-close").click();

                refreshBoard('action=refresh');
            });
        });
    </script>
</body>

</html>