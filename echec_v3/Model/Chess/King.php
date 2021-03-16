<?php
namespace Model\Chess;

final class King extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9812;';
    
    public function getMoves(): array
    {

        return [
            [$this->getX(), $this->getY() - 1],
            [$this->getX(), $this->getY() + 1],
            [$this->getX() + 1, $this->getY()],
            [$this->getX() - 1, $this->getY()],
            [$this->getX() - 1, $this->getY() - 1],
            [$this->getX() - 1, $this->getY() + 1],
            [$this->getX() + 1, $this->getY() + 1],
            [$this->getX() + 1, $this->getY() - 1],
        ];
    }
}