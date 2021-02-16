<?php


    /**
     * displayPlayers
     *
     * @param  array $players
     * 
     * 
     * @return void
     */

        function displayPlayers(array $players) : void
        {
            foreach ($players as $player) {
                echo $player['name'] . PHP_EOL . 
                'Classe : ' .$player['type']['classe'] .PHP_EOL.
                'Stats :  [H: ' . $player['type']['health'] . '][S: ' . $player['type']['strength'] . ']';
                if (array_key_exists('magic', $player['type'])) {
                    echo '[M: ' . $player['type']['magic'] . ']';
                }
                echo  PHP_EOL .'Position : ['. $player['position']['x'] .';'. $player['position']['y'].']' . PHP_EOL . PHP_EOL;
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
                echo PHP_EOL . PHP_EOL;
            }
        }