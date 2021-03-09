<?php
// Affichage des erreurs PHP (à ne pas faire en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auto-chargement des classes
// > on défini une fonction anonyme à appeler en cas d'erreur
spl_autoload_register(function ($sNamespaceClass) {
  //echo '?? '. $sNamespaceClass.PHP_EOL;
  // ex: Model\XXX >> Model/XXX.php
  // ex: Entity\XXX >> Entity/XXX.php
  $sConvertedClass = str_replace('\\', '/', $sNamespaceClass);
  include_once($sConvertedClass.'.php');
});

include_once 'functions.php';

// Permet d'utiliser "MorpionGame" directement au lieu de "Model\MorpionGame"

use Entity\Player;
use Model\ChessGame;

echo '== Début du programme =='.PHP_EOL;

echo '= Leaderboard =' . PHP_EOL;
foreach(Player::loadAll() as $oPlayer) {
  echo sprintf('[%d] %s', $oPlayer->getScore(), $oPlayer->getName()). PHP_EOL;
}
echo '= /Leaderboard =' . PHP_EOL;


// 1. Créer un plateau de jeu
$oGame = new ChessGame();

// 3. Créer les joueurs
foreach (ChessGame::TEAMS as $sTeam) {
    $sName = readline('Pseudo ? ');

    // Récupérer le joueur en BDD si possible, sinon créer le joueur
    // Solution 1 - Non optimisée
    /*$oPlayer = Player::getByName( $sName );
    if ($oPlayer instanceof Player) {
      $oPlayer->setTeam($sTeam);
      $oGame->addPlayer($oPlayer);
    } else {
      $oGame->addPlayer(new Entity\Player($sName, $sTeam));
    }*/

    // Solution 2 - Optimisée (on essaye de raisonner en "action corrective")
    $oPlayer = Player::getByName( $sName );
    if (!$oPlayer instanceof Player) {
      // Action corrective : on construit un Player si celui-ci n'existe pas
      $oPlayer = new Entity\Player($sName, $sTeam);
    }
    // Uniquement dans le cas d'un setter "fluent" (=> return $this)
    $oGame->addPlayer($oPlayer->setTeam($sTeam));
}

$oGame->fillBoard();

// 2. Afficher le plateau de jeu vide
//displayBoard($oGame->getBoard());
$oGame->displayBoard();

// 4. Effectuer un "tour de jeu"
do {
  echo '== Nouveau tour de jeu =='.PHP_EOL;
} while ($oGame->playRound());

echo '== Fin du programme =='.PHP_EOL;