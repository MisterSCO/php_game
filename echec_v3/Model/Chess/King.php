<?php
namespace Model\Chess;

final class King extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9812;';
    
    public function getMoves(): array
    {

        $aMoves = [];

        // Horizontal et vertical
        $aMoves[] = [$this->x, $this->y - 1];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];

        // Diag
        $aMoves[] = [$this->x - 1, $this->y - 1];
        $aMoves[] = [$this->x - 1, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y - 1];

        return  $aMoves;
    }
}