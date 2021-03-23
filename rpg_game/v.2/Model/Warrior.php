<?php
namespace Model;

/*
 * Référentiel de la classe Warrior
 */
final class Warrior extends Character
{
    /**@var string */
    protected const SYMBOL = '&#128119;';

    function __construct($sName = 'Guerrier')
    {
        parent::__construct($sName);

        $this->health = rand(30, 100);
    }
}