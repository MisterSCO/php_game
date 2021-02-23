<?php


/**
 * displayPlayers
 *
 * @param  array $players
 * 
 * 
 * @return void
 */

function displayPlayers(array $players): void
{
    foreach ($players as $player) {
        echo $player['name'] . PHP_EOL .
            'Classe : ' . $player['type']['name'] . PHP_EOL .
            'Stats :  [H: ' . $player['health'] . '][S: ' . $player['strength'] . ']';
        if (array_key_exists('magic', $player)) {
            echo '[M: ' . $player['magic'] . ']';
        }
        echo  PHP_EOL . 'Position : [' . $player['position']['x'] . ';' . $player['position']['y'] . ']' . PHP_EOL . PHP_EOL;
    }
}
    
/**
 * displayBoard
 *
 * @param  array $board
 * @return void
 */
function displayBoard(array $board) : void
{
    for ($y = 0; $y < SIZE_Y; $y++) {
        for ($x = 0; $x < SIZE_X; $x++) {
            if (is_array($board[$y][$x])) {
                $character = $board[$y][$x];
                echo '[ ' . substr($character['name'], 0, 1) . ' ] ';
            } else {
                echo '[' . $x . ',' .  $y . '] ';
            }
        }
        echo PHP_EOL;
        echo PHP_EOL;
    }
}


/**
 * buildStats
 *
 * @param  array $characters
 * 
 */
/* function buildStats (array $characters) {
    $aTypeInfo = $characters['type'];
    $characters['health']  = rand($aTypeInfo['min_health'], $aTypeInfo['max_health']);
    $characters['strength']  = rand($aTypeInfo['min_strength'], $aTypeInfo['max_strength']);

    if ($characters['type'] === TYPE_WIZARD) {
        $characters['magic']  = rand($aTypeInfo['min_magic'], $aTypeInfo['max_magic']);
    }
    return $characters;
} */

/**
 * buildStats
 *
 * @param  array $characters
 * 
 */

/* Meme fonction mais sans retourner la valeur*/

function buildStatsRef(array &$characters)
{
    $aTypeInfo = $characters['type'];
    $characters['health']  = rand($aTypeInfo['min_health'], $aTypeInfo['max_health']);
    $characters['strength']  = rand($aTypeInfo['min_strength'], $aTypeInfo['max_strength']);

    if ($characters['type'] == TYPE_WIZARD) {
        $characters['magic']  = rand($aTypeInfo['min_magic'], $aTypeInfo['max_magic']);
    }
    $characters['position']['x'] = rand(0,SIZE_X - 1);
    $characters['position']['y'] = rand(0, SIZE_Y - 1);
}