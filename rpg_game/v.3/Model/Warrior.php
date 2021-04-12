<?php
namespace Model;

/*
 * Référentiel de la classe Warrior
 */
final class Warrior extends Character
{
    /**@var string */
    public const NAME = 'Guerrier';

    /**@var string */
    public const SYMBOL = '&#128119;';

    /**@var int */
    public const MAX_HEALTH = 150;

    /**@var int */
    public const MAX_STRENGTH = 20;

    /**
     * @param string $sName
     *
     * @return void
     */
    public function __construct(string $sName)
    {
        parent::__construct($sName);

        $this->health = $this->maxHealth = rand(80, self::MAX_HEALTH);
        $this->strength = rand(10, self::MAX_STRENGTH);
    }

    public function getMoves(): array
    {
        $aMoves = [];
        
        // Carré
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x, $this->y - 1];

        return $aMoves;
    }
}