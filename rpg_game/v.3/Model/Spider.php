<?php
namespace Model;

class Spider extends Monster
{
    /**@var int */
    public const NB_MONSTERS = 10;

    /**@var int */
    public const MAX_HEALTH = 10;

    /**@var string */
    public const NAME = 'Araignée';

    /**@var string */
    protected const SYMBOL = '&#128376;';
    
    /**
     * @return void
     */
    public function __construct()
    {
        $this->health = self::MAX_HEALTH;
        $this->strength = 10;
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