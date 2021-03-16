<?php
namespace Model\Chess;

final class Rook extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9814;';

    public function getMoves(): array
    {
        $aMoves = [
            0 => [],
            1 => [],
            2 => [],
            3 => []
        ];
        for ($i = 1; $i < 8; $i++) {
            
            // Horizontal
            $aMoves[0][] = [$this->x, $this->y + $i];
            $aMoves[1][] = [$this->x, $this->y - $i];

            // Vertical
            $aMoves[2][] = [$this->x + $i, $this->y];
            $aMoves[3][] = [$this->x - $i, $this->y];
        }
        return $aMoves;
    }
}