<?php

include('_bootstrap.php');

// On récupère le jeu en session (si existant)
$oGame = isset($_SESSION['game']) ? unserialize($_SESSION['game']) : null;
// On récupère le joueur en session (si existant)
$oPlayer = isset($_SESSION['player']) ? unserialize($_SESSION['player']) : null;

// Création d'une partie
if (isset($_GET['new'])) {
    $oPlayer = new Entity\Player('MisterSCO');
    $oCharacter = new Model\Wizard('Merlin');

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

// Action spécial : clic sur une case
if (isset($_GET['x']) && isset($_GET['y'])) {
    // 2. Action sur le plateau de jeu
    $aGameInfo = $oGame->selectCell($oPlayer, $_GET['x'], $_GET['y']);
}

// Action spécial : refresh automatique
if (isset($_GET['refresh'])) {
    $oGame->lifetime();
}

// On enregistre le jeu "modifié" en session
$_SESSION['game'] = serialize($oGame);
$_SESSION['player'] = serialize($oPlayer);

include('templates/board.php');
exit();


