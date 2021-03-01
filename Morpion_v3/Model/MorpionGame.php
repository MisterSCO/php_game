<?php
namespace Model;


final class MorpionGame
{

    public const SIZE_X = 3;
    public const SIZE_Y = 3;
    public const TEAMS = ['X', 'O'];
    
    
    private $board;
    private $players;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->createBoard();
    }
    
    /**
     * playRound
     *
     * @return void
     */
    public function playRound() : bool
    {
        foreach ($this->getPlayers() as $oPlayer) {
            echo $oPlayer . ' à vous de jouer !' . PHP_EOL;

            do {
                // Obtenir les coordonnées saisies désirées par le joueur
                // readline permet de récupérer une saisie utilisateur
                // explode : permet de scinder une chaîne de caractère en un tableau (plusieurs morceaux)
                // [0] > Premier résultat     [1] > Second résultat
                $sResponse = readline('>> Quelle case ? ');
                $aParts = explode(',',  $sResponse);
                $x = $aParts[0];
                $y = $aParts[1];

                // équivalent à     list($x, $y) = explode(',',  $sResponse);
                // équivalent à     [$x, $y] = explode(',',  $sResponse);

                // On teste si la case est vide ET si les coordonnées sont valides
                // trim = supprime les espaces présents
                $bReplay = (!$this->isValidXY($x, $y)) || !$this->isEmptyXY($x, $y);
                if ($bReplay) {
                    echo 'Case déjà prise OU coordonnées invalides' . PHP_EOL;
                }
                // Condition de "reboucle" : pas valide ou pas vide
            } while ($bReplay);

            // On assigne le joueur/pion dans la case

            $oPawn =  (new Pawn())
                ->setPlayer($oPlayer)
                ->setSymbol($oPlayer->getTeam());

            $this->setXY($x, $y, $oPawn);

            // Affichage plateau après que le joueur est joué
            $this->displayBoard();

            // Il faut appeler isWin après le tour de chaque joueur pour arrêter la partie directement en cas de victoire
            $bWin = $this->isWin();
            if ($bWin) {
                break;
            }
        }
        return !$bWin;
    }
    
    /**
     * addPlayer
     *
     * @param  mixed $player
     * @return void
     */
    public function addPlayer(\Entity\Player $player)
    {
        $this->players[] = $player;

    }

    
    /**
     * isEmptyXY
     *
     * @param  mixed $x
     * @param  mixed $y
     * @return void
     */
    public function isEmptyXY(int $x, int $y)
    {
        return empty(trim($this->board[$y][$x]));
    }
        
    /**
     * isValidXY
     *
     * @param  mixed $x
     * @param  mixed $y
     * @return bool
     */
    public function isValidXY(int $x, int $y): bool
    {
        return ($x >= 0 && $x < self::SIZE_X  && $y >= 0 && $y < self::SIZE_Y);
    }


    
    /**
     * 
     * @return bool
     */
    public function isWin(): bool
    {

        $bLine1 = $this->check([0,0],[1,0],[2,0]);
        $bLine2 = $this->check([0, 1], [1, 1], [2, 1]);
        $bLine3 = $this->check([2, 0], [2, 1], [2, 2]);

        $bLine1 = !empty(trim($this->board[0][0])) && ($this->board[0][0] == $this->board[1][0] && $this->board[0][0] == $this->board[2][0] && $this->board[1][0] == $this->board[2][0]);
        if ($bLine1) {
            echo 'Victoire de ' . $this->board[0][0]->getPlayer(). PHP_EOL;
            return true;
        }
        $bLine2 = !empty(trim($this->board[0][1])) && ($this->board[0][1] == $this->board[1][1] && $this->board[0][1] == $this->board[2][1] && $this->board[1][1] == $this->board[2][1]);
        if ($bLine2) {
            echo 'Victoire de ' . $this->board[0][1]->getPlayer(). PHP_EOL;
            return true;
        }

        $bLine3 = !empty(trim($this->board[0][2])) && ($this->board[0][2] == $this->board[1][2] && $this->board[0][2] == $this->board[2][2] && $this->board[1][2] == $this->board[2][2]);
        if ($bLine3) {
            echo 'Victoire de ' . $this->board[0][2]->getPlayer() . PHP_EOL;
            return true;
        }


        $bCol1 = !empty(trim($this->board[0][0])) && ($this->board[0][0] == $this->board[0][1] && $this->board[0][0] == $this->board[0][2] && $this->board[0][1] == $this->board[0][2]);
        if ($bCol1) {
            echo 'Victoire de ' . $this->board[0][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bCol2 = !empty(trim($this->board[1][0])) && ($this->board[1][0] == $this->board[1][1] && $this->board[1][0] == $this->board[1][2] && $this->board[1][1] == $this->board[1][2]);
        if ($bCol2) {
            echo 'Victoire de ' . $this->board[1][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bCol3 = !empty(trim($this->board[2][0])) && ($this->board[2][0] == $this->board[2][1] && $this->board[2][0] == $this->board[2][2] && $this->board[2][1] == $this->board[2][2]);
        if ($bCol3) {
            echo 'Victoire de ' . $this->board[2][0]->getPlayer(). PHP_EOL;
            return true;
        }


        $bDiagLR = !empty(trim($this->board[0][0])) && ($this->board[0][0] == $this->board[1][1] && $this->board[0][0] == $this->board[2][2] && $this->board[1][1] == $this->board[2][2]);
        if ($bDiagLR) {
            echo 'Victoire de ' . $this->board[0][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bDiagRL = !empty(trim($this->board[2][0])) && ($this->board[2][0] == $this->board[1][1] && $this->board[2][0] == $this->board[0][2] && $this->board[1][1] == $this->board[0][2]);
        if ($bDiagRL) {
            echo 'Victoire de ' . $this->board[2][0]->getPlayer(). PHP_EOL;
            return true;
        }

        $bfullArray = (!empty(trim($this->board[0][0])) && !empty(trim($this->board[0][1])) && !empty(trim($this->board[0][2]))
            && !empty(trim($this->board[1][0])) && !empty(trim($this->board[1][1])) && !empty(trim($this->board[1][2]))
            && !empty(trim($this->board[2][0])) && !empty(trim($this->board[2][1])) && !empty(trim($this->board[2][2])));

        $bCaseNul = $bfullArray && !$bLine1 && !$bLine2 && !$bLine3 && !$bCol1 && !$bCol2 && !$bCol3 && !$bDiagLR && !$bDiagRL;
        if ($bCaseNul) {
            echo 'Match nul' . PHP_EOL;
            return true;
        }
        return false;
    }

    /**
     * displayBoard
     *
     * @return void
     */
    public function displayBoard(): void
    {
        for ($y = 0; $y < self::SIZE_Y; $y++) {
            for ($x = 0; $x < self::SIZE_X; $x++) {
                $mCell = $this->board[$x][$y];
                echo '['.$mCell.']';

            }
            echo PHP_EOL;
            echo PHP_EOL;
        }
    }

    /**
     * creatboard
     *
     * @return array
     */
    private function createBoard()
    {
        $board = [];
        for ($y = 0; $y < self::SIZE_Y; $y++) {
            
            $board[$y] = [];
            for ($x = 0; $x < self::SIZE_X; $x++) 
            {
                $board[$y][$x] = '';
            }
        }
        $this->board = $board;
    }
    
    /**
     * setXY
     *
     * @param  mixed $x
     * @param  mixed $y
     * @param  mixed $oPlayer
     * @return void
     */
    public function setXY(int $x, int $y, Pawn $oPawn)
    {
        $this->board[$y][$x] = $oPawn; // On stocke directement le joueur
    }

    /**
     * Get the value of board
     */ 
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Set the value of board
     *
     * @return  self
     */ 
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }
    /**
     * Get the value of players
     */ 
    public function getPlayers()
    {
        return $this->players;
    }
}