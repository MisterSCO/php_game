<?php
namespace Model;

use Entity\Character;

/**
 * Référentiel de la classe Warrior
 */
final class Warrior extends Character
{
    /**@var string */
    public const NAME = 'Guerrier';

    /**@var string */
    public const SYMBOL = '&#128119;';

    /**@var int */
    public const MIN_HEALTH = 80;

    /**@var int */
    public const MAX_HEALTH = 150;

    /**@var int */
    public const MIN_STRENGTH = 10;

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

        $this->health = $this->maxHealth = rand(self::MIN_HEALTH, self::MAX_HEALTH);
        $this->strength = rand(self::MIN_STRENGTH, self::MAX_STRENGTH);
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
