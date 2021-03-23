<?php

namespace Model;

/**
 * Le but de la classe AbstractGame est de centraliser au maximum tout ce qui concerne "un" jeu de plateau
 * abstract = empêche l'instanciation de la classe (non obligatoire)
 */
abstract class AbstractGame
{

    // On défini la notion de dimensions X et Y
    protected const SIZE_X = NULL;
    protected const SIZE_Y = NULL;

    /** @var array */
    protected $board = [];

    /** @var array */
    protected $players = [];

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
     * @param  $mObject
     * @return void
     */
    protected function setXY(int $x, int $y, $mObject) : void
    {
        $this->board[$y][$x] = $mObject;
    }

    protected abstract function selectCell(\Entity\Player $oPlayer, int $x, int $y): array;


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

}