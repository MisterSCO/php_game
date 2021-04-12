<?php
namespace Model;

/*
 * Référentiel de la classe Warrior
 */
final class Warrior extends Character
{
    /**@var string */
    protected const SYMBOL = '&#128119;';

    function __construct(string $sName = 'Guerrier')
    {
        parent::__construct($sName);

        $this->health = rand(80, 150);
        $this->MaxHealth = $this->health;
        $this->strength = rand(10, 20);
    }

    function getMoveAttack(): array
    {
        $aAttack = [];

        $aAttack[] = [$this->x, $this->y + 1];
        $aAttack[] = [$this->x + 1, $this->y + 1];
        $aAttack[] = [$this->x + 1, $this->y];
        $aAttack[] = [$this->x + 1, $this->y - 1];
        $aAttack[] = [$this->x, $this->y - 1];
        $aAttack[] = [$this->x - 1, $this->y - 1];
        $aAttack[] = [$this->x - 1, $this->y];
        $aAttack[] = [$this->x - 1, $this->y + 1];

        return $aAttack;
    }
}