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

        $this->MaxHealth = 100;
        $this->health = rand(30, $this->MaxHealth);
    }
}