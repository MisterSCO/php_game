<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


spl_autoload_register(
  function ($sNamespaceClass) {
    echo '> '. $sNamespaceClass.PHP_EOL;

    $sConvert =  str_replace( "\\", "/" , $sNamespaceClass);
    $sFilePath = $sConvert . '.php';
    include_once($sFilePath);
  }
);

/* include_once 'model/Player.php';
include_once 'model/Game.php'; */

use Model\MorpionGame as MorpionGame;
include_once 'functions.php';



echo '== Début du programme =='.PHP_EOL;

// 1. Créer un plateau de jeu 3x3
$oGame = new MorpionGame();

// 2. Afficher le plateau de jeu vide
$oGame->displayBoard();

// 3. Créer un tableau de joueurs et ajouter 2 joueurs
$aPlayers = [];
/*
for ($i = 0 ; $i < 2 ; $i++) {
    $sName = readline('Prénom ? ');
    $aPlayers[] = new Player($sName, $aPawns[$i]);
}
*/
foreach (MorpionGame::TEAMS as $sPawn) {
    $sName = readline('Prénom ? ');
    $oGame->addPlayer(new Entity\Player($sName,$sPawn));
}

// 4. Effectuer un "tour de jeu"
do {
  echo '== Nouveau tour de jeu ==' . PHP_EOL;
} while ($oGame->playRound());



echo '== Fin du programme =='.PHP_EOL;
