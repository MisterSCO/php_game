<?php
namespace Model\Chess;

final class Knight extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9816;';

    public function getMoves(): array
    {

        return [
            [$this->getX() + 1, $this->getY() - 2],
            [$this->getX() - 1, $this->getY() - 2],
            [$this->getX() - 1, $this->getY() + 2],
            [$this->getX() + 1, $this->getY() + 2],

            [$this->getX() + 2, $this->getY() - 1],
            [$this->getX() - 2, $this->getY() - 1],
            [$this->getX() - 2, $this->getY() + 1],
            [$this->getX() + 2, $this->getY() + 1],
        ];
    }
}