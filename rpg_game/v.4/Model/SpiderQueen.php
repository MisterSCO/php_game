<?php
namespace Model;

class SpiderQueen extends Monster
{
    /**@var int */
    public const NB_MONSTERS = 1;

    /**@var int */
    public const MAX_HEALTH = 50;

    /**@var string */
    public const NAME = 'Reine araignée';

    /**@var string */
    protected const SYMBOL = '&#128375;';
    
    /**
     * @return void
     */
    public function __construct()
    {
        $this->health = self::MAX_HEALTH;
        $this->strength = 25;
    }

    public function getMoves(): array
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