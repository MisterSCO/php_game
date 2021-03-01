<?php
namespace Model;

/**
 * Le but de la classe AbstractGame est de centraliser au maximum tout ce qui concerne les jeux
 * (dont le plateau de jeu)
 * 
 */
abstract class AbstractGame{
    // On défini la notion d'équipes
    public const TEAMS = [];

    // On défini la notion de dimensions
    protected const SIZE_X = NULL;
    protected const SIZE_Y = NULL;

    /** @var array */
    protected $board = [];

    /** @var array */
    protected $players = [];


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
    protected static function isValidXY(int $x, int $y): bool
    {
        return $x >= 0 && $x < static::SIZE_X && $y >= 0 && $y < static::SIZE_Y;
    }

    /**
     * trim = supprime les espaces présents
     * @param  int $x
     * @param  int $y
     * @return bool
     */
    protected function isEmptyXY(int $x, int $y): bool
    {
        return empty(trim($this->board[$y][$x]));
    }


    protected abstract function playerAction(\Entity\Player $oPlayer) : void;

    protected abstract function isWinUltraOptimized(): bool;

    public function playRound(): bool
    {
        foreach ($this->getPlayers() as $oPlayer) {
            echo $oPlayer . ' à vous de jouer !' . PHP_EOL;

            $this->playerAction($oPlayer);
            // Affichage plateau après que le joueur est joué
            $this->displayBoard();

            // Il faut appeler isWin après le tour de chaque joueur pour arrêter la partie directement en cas de victoire
            $bWin = $this->isWinUltraOptimized();
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
            for ($x = 0; $x < static::SIZE_X;
                $x++
            ) {
                // Variable intermédiaire pour alléger le code
                $mCell = $this->board[$y][$x];
                echo '[' . $mCell . ']';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    /**
     * Vérifie si les coordonnées $x, $y sont valides
     *
     * @param  int $x
     * @param  int $y
     * @param  Player $oPlayer
     * @return void
     */
    protected function setXY(int $x, int $y,Pawn $oPawn): void 
    {
        $this->board[$y][$x] = $oPawn;
    }
    /**
     * Create a board
     *
     * @return array
     */
    private function initBoard(): void
    {
        $board = [];

        // -- Initialisation des lignes
        for ($y = 0; $y < static::SIZE_Y; $y++) {
            $board[$y] = [];

            // -- Initialisation des colonnes
            for ($x = 0; $x < static::SIZE_X; $x++) {
                $board[$y][$x] = ' ';
            }
        }

        $this->board = $board;
    }
    /**
     * @param  Player $player
     * @return void
     */
    public function addPlayer(\Entity\Player $player): void
    {
        $this->players[] = $player;
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
}