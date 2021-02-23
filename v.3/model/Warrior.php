<?php

include_once 'model/Character.php';

/**
 * Warrior
 */
final class Warrior extends Character
{

    /* 
        Propriétés/Attributs
        Convention de code : camelCase
    */

    
    /*
    * Constructeur de la classe Warrior
    * On attend un paramètre correspondant au nom
    * Valeur facultative. Si pas présent, valeur par défaut : Guerrier
    */
    public function __construct(string $sName = 'Guerrier')
    {
        $this->name =$sName;
    }

    public function display()
    {
        print_r($this);
    }

    
}