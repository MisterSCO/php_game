<?php

use Entity\Player;

include('_bootstrap.php');

// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
$oPlayer = $oGame ? $oGame->getPlayers()[0] : null;

// Action spéciale : création d'une partie
if (isset($_GET['new'])) {
    $oPlayer = new Entity\Player('F2000');
    $oCharacter = new Model\Wizard('Gandalf');
    
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
}

// Test de "sécurité"
if (!$oGame || !$oPlayer) {
    exit;
}

$aGameInfo = [];
switch ($_GET['action'] ?? '') {
    case 'create_player':
      $oPlayer = $oCharacter = null;

      // Step 1
      if (isset($_GET['playername'])) {
        $oPlayer = Entity\Player::getByName($_GET['playername']);

        if (!$oPlayer instanceof Entity\Player) {
          $oPlayer = new Entity\Player($_GET['playername']);
        }
      }

      // Step 2
      if ($oPlayer && isset($_GET['namecharac']) && isset($_GET['classcharac']))
      {
        $oCharacter = new $_GET['classcharac']($_GET['namecharac']);
        // Liaisons Player-Character / Character-Player
        $oPlayer->setCharacter($oCharacter);
        $oCharacter->setPlayer($oPlayer);
        
      }
      
      // Step 3
      /* if ($oCharacter && ) {
        # code...
      } */

      include('templates/choose_player.php');
      exit();
      break;

    case 'select':
        // Action spéciale : clic sur une case
        if (isset($_GET['x']) && isset($_GET['y'])) {
            $aGameInfo = $oGame->selectCell($oPlayer, $_GET['x'], $_GET['y']);
        }
        break;

    case 'attack':
        // Action spéciale : attaque
        $oGame->attack($oPlayer);
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