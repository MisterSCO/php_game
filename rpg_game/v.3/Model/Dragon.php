<?php
namespace Model;

class Dragon extends Monster
{
    /**@var int */
    public const NB_MONSTERS = 1;

    /**@var int */
    public const MAX_HEALTH = 200;

    /**@var string */
    public const NAME = 'Dragon';

    /**@var string */
    protected const SYMBOL = '&#128009;';
    
    /**
     * @return void
     */
    public function __construct()
    {
        $this->health = self::MAX_HEALTH;
        $this->strength = 50;
    }

    public function getAttackCells(): array
    {
        $aMoves = [];

        // Diag
        $aMoves[] = [$this->x - 1, $this->y - 1];
        $aMoves[] = [$this->x - 1, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y - 1];
        $aMoves[] = [$this->x + 1, $this->y + 1];

        // Carré
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x, $this->y - 1];

        return $aMoves;
    }
}