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
}