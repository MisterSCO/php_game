<?php

error_reporting(E_ALL);
ini_set('display_error', 1);

include_once 'functions.php';
include_once 'models/Player.php';
include_once 'models/Game.php';



const MAX_PLAYERS = 2;

echo '';

// TODO : créer un plateau de jeu 3x3
// ...
$oGame = new Game();

// TODO : afficher le plateau de jeu vide
// ...

$players=[];
$aPawns = ['X','O'];

foreach ($aPawns as $sPawn) {
    $name = readline('CHOISIS UN PSEUDO MANAN!!!!! >>');
    $

    $players[] = new Player($name,$sPawn);
    
    PHP_EOL;

}

$oGame->displayBoard();


// TODO : créer un tableau de joueurs
// ...

/* $players= [];

// TODO : ajouter deux joueur
// ...

$players[] = 'O';
$players[] = 'X';
 */
// TODO : effectuer un tour de jeu
// ...
$bWin = true;
do {
    foreach ($players as $player) {
        do {
            echo $player->getName() . ' à vous de jouer!' . PHP_EOL;
            $sResponse = readline('>> Quelle case? ');
            
            print_r($sResponse . PHP_EOL);
            
            $aPart = explode(',' , $sResponse);
            $x = $aPart['0'];
            $y = $aPart['1'];
            
            echo 'X : '.$x . PHP_EOL;
            echo 'Y : '.$y . PHP_EOL;

            $bReplay = (!$oGame->isValidXY($x, $y)) || (!empty(trim($oGame->getBoard[$y][$x])));
            
            if ($bReplay)
            {
                echo 'Cette case n\'est pas valide, merci de reproposer des coordonnées' . PHP_EOL;
            }
        } while ($bReplay);
        
        $board=$oGame->getBoard();
        $board[$y][$x] = $player->getSymbol();
        $oGame->setBoard($board);
        $oGame->displayBoard();

        $bWin = isWin($board);
        if ($bWin) {
            break;
        }
    }
} while (!$bWin);
