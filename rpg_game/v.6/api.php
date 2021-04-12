<?php
include('_bootstrap.php');

// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
$oPlayer = $oGame && count($oGame->getPlayers()) > 0 ? $oGame->getPlayers()[0] : null;

// Test de "sécurité"
if (!$oGame) {
    exit;
}

$sTemplate = 'board.php';

$aGameInfo = [];
switch ($_GET['action'] ?? '') {
    case 'create_player':
        // Action spéciale : création d'un joueur/personnage
        $oPlayer = null;
        $oCharacter = isset($_SESSION['last_character']) ? unserialize($_SESSION['last_character']) : null;

        // Step 1 : recherche du joueur
        if (isset($_GET['player_name'])) {
            $oPlayer = Entity\Player::getByName($_GET['player_name']);
            if (!$oPlayer instanceof Entity\Player) {
                $oPlayer = new Entity\Player($_GET['player_name']);
            }
        }

        // Step 2 : création du personnage
        if ($oPlayer && !empty($_GET['character_id'])) {
            // Recherche du personnage existant
            foreach ($oPlayer->getCharacters() as $oCharacter) {
                if ($oCharacter->getId() === (int) $_GET['character_id']) {
                    // Memorize character info
                    $_SESSION['last_character'] = serialize($oCharacter);
                    break;
                }
            }

            $oPlayer->setCharacter($oCharacter->setPlayer($oPlayer));
        }
        elseif ($oPlayer && isset($_GET['character_class']) && isset($_GET['character_name'])) {
            if (!isset($_GET['save'])) {
                $oCharacter = new $_GET['character_class']($_GET['character_name']);
            }

            // Memorize character info
            $_SESSION['last_character'] = serialize($oCharacter);

            // -- refresh info
            $oCharacter
                ->setName($_GET['character_name'])
                ->setPlayer($oPlayer)
            ;
            $oPlayer->setCharacter($oCharacter);
        }

        // Step 3 : sauvegarde
        if ($oCharacter && isset($_GET['save'])) {
            $oGame->addPlayer($oPlayer);
            $oPlayer->save();
        }

        $sTemplate = 'choose_player.php';
        break;

    case 'select':
        // Action spéciale : clic sur une case
        if ($oPlayer && isset($_GET['x']) && isset($_GET['y'])) {
            $aGameInfo = $oGame->selectCell($oPlayer, $_GET['x'], $_GET['y']);
        }
        break;

    case 'attack':
        // Action spéciale : attaque
        if ($oPlayer) {
            $oGame->attack($oPlayer);
        }
        break;

    case 'refresh':
        // Action spéciale : refresh automatique
        $oGame->lifetime();
        break;
}

// On enregistre le jeu "modifié" en session
$_SESSION['game'] = serialize($oGame);

include('templates/'.$sTemplate);
exit();
