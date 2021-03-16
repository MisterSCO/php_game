<?php
namespace Model\Chess;

final class Knight extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9816;';

    public function getMoves(): array
    {

        $aMoves = [];

        // Horizontal
        $aMoves[] = [$this->x + 1, $this->y - 2];
        $aMoves[] = [$this->x - 1, $this->y - 2];
        $aMoves[] = [$this->x - 1, $this->y + 2];
        $aMoves[] = [$this->x + 1, $this->y + 2];

        // Vertical
        $aMoves[] = [$this->x + 2, $this->y - 1];
        $aMoves[] = [$this->x - 2, $this->y - 1];
        $aMoves[] = [$this->x - 2, $this->y + 1];
        $aMoves[] = [$this->x + 2, $this->y + 1];

        return  $aMoves;
    }
}