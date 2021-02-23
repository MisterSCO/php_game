<?php

function creatboard() : array
{
    $board = [];

    for ($y = 0; $y < SIZE_Y; $y++) {
        $board[$y] = [];
        for ($x = 0; $x < SIZE_X; $x++) {
            $board[$y][$x] = '';
        }
    }
    return $board;
}

function displayBoard(array $board): void
{
    for ($y = 0; $y < SIZE_Y; $y++) {
        for ($x = 0; $x < SIZE_X; $x++) {
            echo '[ '. $board[$y][$x] . ' ] ';
        }
        echo PHP_EOL;
        echo PHP_EOL;
    }
}

/**
 * isValidXY
 *
 * @param  int $x
 * @param  int $y
 * @return bool
 */
function isValidXY(int $x , int $y) : bool
{
    return($x >= 0 && $x < SIZE_X  && $y >= 0 && $y < SIZE_Y);
}

function isWin(array $board) : bool
{
    $bLine1 = !empty(trim($board[0][0])) && ($board[0][0] === $board [1][0] && $board[0][0] === $board[2][0] && $board[1][0] === $board[2][0]);
    if ($bLine1) {
        echo 'Victoire de '. $board[0][0];
        return true;
    }
    $bLine2 = !empty(trim($board[0][1])) && ($board[0][1] === $board[1][1] && $board[0][1] === $board[2][1] && $board[1][1] === $board[2][1]);
    if ($bLine2) {
        echo 'Victoire de ' . $board[0][1];
        return true;
    }

    $bLine3 = !empty(trim($board[0][2])) && ($board[0][2] === $board[1][2] && $board[0][2] === $board[2][2] && $board[1][2] === $board[2][2]);
    if ($bLine3) {
        echo 'Victoire de ' . $board[0][2];
        return true;
    }


    $bCol1 = !empty(trim($board[0][0])) && ($board[0][0] === $board[0][1] && $board[0][0] === $board[0][2] && $board[0][1] === $board[0][2]);
    if ($bCol1) {
        echo 'Victoire de ' . $board[0][0];
        return true;
    }

    $bCol2 = !empty(trim($board[1][0])) && ($board[1][0] === $board[1][1] && $board[1][0] === $board[1][2] && $board[1][1] === $board[1][2]);
    if ($bCol2) {
        echo 'Victoire de ' . $board[1][0];
        return true;
    }

    $bCol3 = !empty(trim($board[2][0])) && ($board[2][0] === $board[2][1] && $board[2][0] === $board[2][2] && $board[2][1] === $board[2][2]);
    if ($bCol3) {
        echo 'Victoire de ' . $board[2][0];
        return true;
    }


    $bDiagLR = !empty(trim($board[0][0])) && ($board[0][0] === $board[1][1] && $board[0][0] === $board[2][2] && $board[1][1] === $board[2][2]);
    if ($bDiagLR) {
        echo 'Victoire de ' . $board[0][0];
        return true;
    }

    $bDiagRL = !empty(trim($board[2][0])) && ($board[2][0] === $board[1][1] && $board[2][0] === $board[0][2] && $board[1][1] === $board[0][2]);
    if ($bDiagRL) {
        echo 'Victoire de ' . $board[2][0];
        return true;
    }
    return false;
}