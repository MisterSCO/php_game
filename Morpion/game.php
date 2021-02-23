<?php
error_reporting(E_ALL);
ini_set('display_error', 1);

include_once 'functions.php';

const SIZE_X = 3;
const SIZE_Y = 3;

echo '';

// TODO : créer un plateau de jeu 3x3
// ...

$board = creatboard();

// TODO : afficher le plateau de jeu vide
// ...

displayBoard($board);


// TODO : créer un tableau de joueurs
// ...

$aPlayers= [];

// TODO : ajouter deux joueur
// ...

$aPlayers[] = 'O';
$aPlayers[] = 'X';

// TODO : effectuer un tour de jeu
// ...
do {
    foreach ($aPlayers as $aPlayer) {
        do {
            echo $aPlayer . ' à vous de jouer!' . PHP_EOL;
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
        
        $board[$y][$x] = $aPlayer;
        displayBoard($board);

        $bWin = isWin($board);
        if ($bWin) {
            break;
        }
    }
} while (!$bWin);
