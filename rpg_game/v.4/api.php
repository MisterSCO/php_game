<?php
include('_bootstrap.php');

// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
$oPlayer = $oGame && count($oGame->getPlayers()) > 0 ? $oGame->getPlayers()[0] : null;

// Action spéciale : création d'une partie


// Test de "sécurité"
if (!$oGame) {
    exit;
}

$aGameInfo = [];
switch ($_GET['action'] ?? '') {
    case 'create_player':
        // Action spéciale : création d'un joueur/personnage
        
        $oPlayer = $oCharacter = null;

        // Step 1 : recherche du joueur
        if (isset($_GET['player_name'])) {
            $oPlayer = Entity\Player::getByName($_GET['player_name']);
            if (!$oPlayer instanceof Entity\Player) {
                $oPlayer = new Entity\Player($_GET['player_name']);
            }
        }

        // Step 2 : création du personnage
        if ($oPlayer && isset($_GET['class']) && isset($_GET['character_name'])) {
            $oCharacter = new $_GET['class']($_GET['character_name']);
            $oPlayer->setCharacter($oCharacter->setPlayer($oPlayer));
        }
        

        // Step 3 : sauvegarde
        
        if ($oCharacter && isset($_GET['save'])) {
            $oPlayer->save();
            $oGame->addPlayer($oPlayer);
            $_SESSION['game'] = serialize($oGame);
        }

        include('templates/choose_player.php');
        exit();
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
$_SESSION['player'] = serialize($oPlayer);

include('templates/board.php');
exit();