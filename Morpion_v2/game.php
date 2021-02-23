<?php

error_reporting(E_ALL);
ini_set('display_error', 1);

include_once 'functions.php';
include_once 'model/player.php';

const SIZE_X = 3;
const SIZE_Y = 3;

echo '';

// TODO : créer un plateau de jeu 3x3
// ...

$board = creatboard();

// TODO : afficher le plateau de jeu vide
// ...

$players=[];

$player1 = new Player;
$name1 = readline('CHOISIS UN PSEUDO MANAN!!!!! >>');
$player1 -> setName($name1);
$player1 -> setSymbol('O');

echo PHP_EOL . $name1 . ' joue les ' . $player1->getSymbol() . PHP_EOL;

$player2 = new Player;
$name2 = readline('CHOISIS UN PSEUDO MANAN!!!!! >>');
$player2->setName($name2);
$player2->setSymbol('X');

echo PHP_EOL . $name2 . ' joue les ' . $player2->getSymbol() . PHP_EOL;


$players =[$player1, $player2];


displayBoard($board);


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

            $unvalidate = (!isValidXY($x, $y)) || (!empty(trim($board[$y][$x])));
            
            if ($unvalidate)
            {
                echo 'Cette case n\'est pas valide, merci de reproposer des coordonnées' . PHP_EOL;
            }
        } while ($unvalidate);
        
        $board[$y][$x] = $player->getSymbol();
        displayBoard($board);

        $bWin = isWin($board);
        if ($bWin) {
            break;
        }
    }
} while (!$bWin);
