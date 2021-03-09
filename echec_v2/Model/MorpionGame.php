<?php
namespace Model;

// On aurait pu simplifier le code
//use \Entity\Player;

/**
 * Le but de la classe MorpionGame est de centraliser au maximum tout ce qui concerne le jeu "Morpion"
 * (dont le plateau de jeu)
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class MorpionGame extends AbstractGame
{
    // On précise les équipes
    public const TEAMS = ['X', 'O'];

    // On précise les dimensions
    protected const SIZE_X = 3;
    protected const SIZE_Y = 3;
    
    public function playerAction(\Entity\Player $oPlayer) : void
    {
        do {
            // Obtenir les coordonnées saisies désirées par le joueur
            // readline permet de récupérer une saisie utilisateur
            // explode : permet de scinder une chaîne de caractère en un tableau (plusieurs morceaux)
            $sResponse = readline('>> Quelle case ? ');  
            list($x, $y) = explode(',',  $sResponse);
    
            // On teste si la case est vide ET si les coordonnées sont valides
            $bReplay = !$this->isValidXY($x, $y) || !$this->isEmptyXY($x, $y);
            // Comme isValidXY est static on peut l'appeler depuis le référentiel statiquement
            //$bReplay = !static::isValidXY($x, $y) || !$this->isEmptyXY($x, $y);
            if ($bReplay) {
            echo 'Case déjà prise OU coordonnées invalides'.PHP_EOL;
            }
            // Condition de "reboucle" : pas valide ou pas vide
        } while ($bReplay);
    
        // On assigne le joueur/pion dans la case
        $oPawn = (new Pawn())
            ->setPlayer($oPlayer)
            ->setSymbol($oPlayer->getTeam())
        ;
        $this->setXY($x, $y, $oPawn);
    }
    
    /**
     * /!\ Rappel : $board[y][x] /!\
     * @return bool
     */
    function isWin() : bool
    {
        $bLine1 = !empty(trim($this->board[0][0])) && ($this->board[0][0] == $this->board[0][1]) && ($this->board[0][1] == $this->board[0][2]);
        if ($bLine1) {
            echo 'Victoire de '. $this->board[0][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bLine2 = !empty(trim($this->board[1][0])) && ($this->board[1][0] == $this->board[1][1]) && ($this->board[1][1] == $this->board[1][2]);
        if ($bLine2) {
            echo 'Victoire de '. $this->board[1][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bLine3 = !empty(trim($this->board[2][0])) && ($this->board[2][0] == $this->board[2][1]) && ($this->board[2][1] == $this->board[2][2]);
        if ($bLine3) {
            echo 'Victoire de '. $this->board[2][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bCol1 = !empty(trim($this->board[0][0])) && ($this->board[0][0] == $this->board[1][0]) && ($this->board[1][0] == $this->board[2][0]);
        if ($bCol1) {
            echo 'Victoire de '. $this->board[0][0]->getPlayer(). PHP_EOL;
            return true;
        };

        $bCol2 = !empty(trim($this->board[0][1])) && ($this->board[0][1] == $this->board[1][1]) && ($this->board[1][1] == $this->board[2][1]);
        if ($bCol2) {
            echo 'Victoire de '. $this->board[0][1]->getPlayer(). PHP_EOL;
            return true;
        };

        $bCol3 = !empty(trim($this->board[0][2])) && ($this->board[0][2] == $this->board[1][2]) && ($this->board[1][2] == $this->board[2][2]);
        if ($bCol3) {
            echo 'Victoire de '. $this->board[0][2]->getPlayer(). PHP_EOL;
            return true;
        };

        $bDiaLR = !empty(trim($this->board[0][0])) && ($this->board[0][0] == $this->board[1][1]) && ($this->board[1][1] == $this->board[2][2]);
        if ($bDiaLR) {
            echo 'Victoire de '. $this->board[0][0]->getPlayer(). PHP_EOL;
            return true;
        };
        $bDiaRL = !empty(trim($this->board[0][2])) && ($this->board[0][2] == $this->board[1][1]) && ($this->board[1][1] == $this->board[2][0]);
        if ($bDiaRL) {
            echo 'Victoire de '. $this->board[0][2]->getPlayer() . PHP_EOL;
            return true;
        };
        
        $bTie = !empty(trim($this->board[0][0])) && !empty(trim($this->board[0][1])) && !empty(trim($this->board[0][2]))
                && !empty(trim($this->board[1][0])) && !empty(trim($this->board[1][1])) && !empty(trim($this->board[1][2]))
                && !empty(trim($this->board[2][0])) && !empty(trim($this->board[2][1])) && !empty(trim($this->board[2][2]));
        if ($bTie) {
            echo 'Match nul ! :\'('. PHP_EOL;
            return true;
        };

        return false;
    }

    /**
     * Solution optimisée utilisant checkWin ()
     * /!\ Rappel : $board[y][x] /!\
     * @return bool
     */
    private function isWinOptimized() : bool
    {
        $oWinner = null;

        // Solution optimisée
        $bLine1 = $this->checkWin([ [0,0], [0,1], [0,2] ]);
        $bLine2 = $this->checkWin([ [1,0], [1,1], [1,2] ]);
        $bLine3 = $this->checkWin([ [2,0], [2,1], [2,2] ]);
        
        $bCol1 = $this->checkWin([ [0,0], [1,0], [2,0] ]);
        $bCol2 = $this->checkWin([ [0,1], [1,1], [2,1] ]);
        $bCol3 = $this->checkWin([ [0,2], [1,2], [2,2] ]);

        $bDiaLR = $this->checkWin([ [0,0], [1,1], [2,2] ]);
        $bDiaRL = $this->checkWin([ [0,2], [1,1], [2,0] ]);
        
        if ($bLine1) {
            $oWinner = $this->board[0][0]->getPlayer();
        }
        elseif ($bLine2) {
            $oWinner = $this->board[1][0]->getPlayer();
        }
        elseif ($bLine3) {
            $oWinner = $this->board[2][0]->getPlayer();
        }
        elseif ($bCol1) {
            $oWinner = $this->board[0][0]->getPlayer();
        }
        elseif ($bCol2) {
            $oWinner = $this->board[0][1]->getPlayer();
        }
        elseif ($bCol3) {
            $oWinner = $this->board[0][2]->getPlayer();
        }
        elseif ($bDiaLR) {
            $oWinner = $this->board[0][0]->getPlayer();
        }
        elseif ($bDiaRL) {
            $oWinner = $this->board[0][2]->getPlayer();
        }

        if ($oWinner) {
            echo 'Victoire de '. $oWinner. PHP_EOL;
            return true;
        }
        
        $bTie = true;
        for ($y = 0; $y < self::SIZE_Y; $y++) {
            for ($x = 0; $x < self::SIZE_X; $x++) {
                $bTie = $bTie && !empty(trim($this->board[$y][$x]));
            }
        }
        
        if ($bTie) {
            echo 'Match nul ! :\'('. PHP_EOL;
            return true;
        };

        return false;
    }

    /**
     * Solution ultra optimisée utilisant checkWin ()
     * /!\ Rappel : $board[y][x] /!\
     * @return bool
     */
    private function isWinUltraOptimized() : bool
    {
        $oWinner = null;
        
        $aChecks = [
            [ [0,0], [0,1], [0,2] ],        // Line 1
            [ [1,0], [1,1], [1,2] ],        // Line 2
            [ [2,0], [2,1], [2,2] ],        // Line 3
            [ [0,0], [1,0], [2,0] ],        // Col 1
            [ [0,1], [1,1], [2,1] ],        // Col 2
            [ [0,2], [1,2], [2,2] ],        // Col 3
            [ [0,0], [1,1], [2,2] ],        // Diag LR
            [ [0,2], [1,1], [2,0] ],        // Diag RL
        ];
        foreach ($aChecks as $aCheckData) {
            $bIsWinLine = $this->checkWin($aCheckData);
            if ($bIsWinLine) {
                $oWinner = $this->board[ $aCheckData[0][0] ][ $aCheckData[0][1] ]->getPlayer();
            }
        }

        if ($oWinner) {
            echo 'Victoire de '. $oWinner. PHP_EOL;
            return true;
        }

        $bTie = true;
        for ($y = 0; $y < self::SIZE_Y; $y++) {
            for ($x = 0; $x < self::SIZE_X; $x++) {
                $bTie = $bTie && !empty(trim($this->board[$y][$x]));
            }
        }

        if ($bTie) {
            echo 'Match nul ! :\'('. PHP_EOL;
            return true;
        };

        return false;
    }

    /**
     * @param array $aListCoords
     *
     * @return bool
     */
    private function checkWin (array $aListCoords) : bool
    {
        return !empty(trim($this->board[ $aListCoords[0][0]  ][ $aListCoords[0][1] ])) 
                && ($this->board[ $aListCoords[0][0]  ][ $aListCoords[0][1] ] 
                        == $this->board[ $aListCoords[1][0] ][ $aListCoords[1][1] ]) 
                && ($this->board[ $aListCoords[1][0] ][ $aListCoords[1][1] ] 
                        == $this->board[ $aListCoords[2][0] ][ $aListCoords[2][1] ])
        ;
    }
}