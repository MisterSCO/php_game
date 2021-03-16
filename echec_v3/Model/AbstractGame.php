<?php

namespace Model;

/**
 * Le but de la classe AbstractGame est de centraliser au maximum tout ce qui concerne "un" jeu de plateau
 * abstract = empêche l'instanciation de la classe (non obligatoire)
 */
abstract class AbstractGame
{
    // On défini la notion d'équipe
    public const TEAMS = [];

    // On défini la notion de dimensions X et Y
    protected const SIZE_X = NULL;
    protected const SIZE_Y = NULL;

    // Variable static = variable liée/unique au référentiel
    public static $cpt;

    /** @var array */
    protected $board = [];

    /** @var array */
    protected $players = [];

    /** @var \Entity\Player|null */
    protected ?\Entity\Player $currentPlayer = null;

    /**
     * __construct est appellée automatiquement lors de l'instanciation de l'objet (= new)
     */
    public function __construct()
    {
        $this->initBoard(); 
    }

    /**
     * Vérifie si les coordonnées $x, $y sont valides
     * static = fonction liée au référentiel AbstractGame
     *
     * @param  int $x
     * @param  int $y
     * @return bool
     */
    protected static function isValidXY(int $x, int $y) : bool
    {
        return $x >= 0 && $x < static::SIZE_X && $y >= 0 && $y < static::SIZE_Y;
    }

    /**
     * trim = supprime les espaces présents
     * @param  int $x
     * @param  int $y
     * @return bool
     */
    protected function isEmptyXY(int $x, int $y) : bool
    {
        return empty(trim($this->board[$y][$x]));
    }

    protected function getXY(int $x, int $y)
    {
        return $this->board[$y][$x];
    }


    /**
     * Vérifie si les coordonnées $x, $y sont valides
     *
     * @param  int $x
     * @param  int $y
     * @param  Pawn $oPawn
     * @return void
     */
    protected function setXY(int $x, int $y, Pawn $oPawn) : void
    {
        $this->board[$y][$x] = $oPawn;
    }

    protected abstract function playerAction (\Entity\Player $oPlayer) : void;
    protected abstract function selectCell(int $x, int $y): array;
    protected abstract function isWin () : bool;
    
    
    /**
     * nextPlayer
     *
     * @return void
     */
    protected function nextPlayer() : void 
    {
        // $this->players       = tableau de joueurs
        // $this->currentPlayer = joueur actuel

        //in_array ($value , $array) : bool
        // array_search ($value,$array) : int (= index) ou FALSE

        $iIdxPlayer = array_search($this->currentPlayer, $this->players);
        if ($iIdxPlayer !== false) {
            $iIdxPlayer++;
            $iNbPlayers = count($this->players);

            // Solution 1 
            /* if ($iIdxPlayer >= $iNbPlayers) {
                $iIdxPlayer = 0;
            } */

            // Solution 2 (% = reste de la division (ex : 9%2 = 1))
            
            $this->currentPlayer = $this->players[$iIdxPlayer%$iNbPlayers];
        }
    }

    /**
     * @return bool
     */
    public function playRound() : bool 
    {
        foreach ($this->getPlayers() as $oPlayer) {
            echo $oPlayer.' à vous de jouer !' . PHP_EOL;
            $oPlayer->save();
        
            // Le joueur joue
            $this->playerAction($oPlayer);
        
            // Affichage plateau après que le joueur est joué
            $this->displayBoard();
        
            // Il faut appeler isWin après le tour de chaque joueur pour arrêter la partie directement en cas de victoire
            $bWin = $this->isWin();
            if ($bWin) {
                break;
            }
        }

        // On retourne la condition de "Peut-on rejouer ?"
        return !$bWin;
    }

    /**
     * Display the board
     *
     * @return void
     */
    public function displayBoard(): void
    {
        // -- Parcours des lignes
        for ($y = 0; $y < static::SIZE_Y; $y++) {
            // -- Parcours des colonnes
            for ($x = 0; $x < static::SIZE_X; $x++) {
                // Variable intermédiaire pour alléger le code
                $mCell = $this->board[$y][$x];
                echo '['. $mCell .']';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    /**
     * Initialize a board
     *
     * @return array
     */
    private function initBoard(): void
    {
        $board = [];

        // -- Initialisation des lignes
        for ($y = 0 ; $y < static::SIZE_Y ; $y++) {
            $board[ $y ] = [];

            // -- Initialisation des colonnes
            for ($x = 0 ; $x < static::SIZE_X ; $x++) {
                $board[ $y ][ $x ] = ' ';
            }
        }

        $this->board = $board;
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

    /**
     * Set the value of players
     *
     * @return  self
     */ 
    public function setPlayers($players)
    {
        $this->players = $players;

        return $this;
    }
        
    /**
     * @param  Player $player
     * @return void
     */
    public function addPlayer(\Entity\Player $player) : void
    {
        $this->players[] = $player;
    }

    /**
     * Get the value of currentPlayer
     */ 
    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }

    /**
     * Set the value of currentPlayer
     *
     * @return  self
     */ 
    public function setCurrentPlayer($currentPlayer)
    {
        $this->currentPlayer = $currentPlayer;

        return $this;
    }
}