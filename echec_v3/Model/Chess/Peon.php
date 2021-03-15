<?php
namespace Model\Chess;


final class Peon extends \Model\Pawn 
{
    

    /**@var string */
    protected const SYMBOL = '&#9817;';


    public function getMoves(): array
    {
        
        return [[$this->getX(), $this->getY()-1], [$this->getX(), $this->getY() - 2]];
        
    }
}