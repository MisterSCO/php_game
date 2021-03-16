<?php
namespace Model\Chess;

final class Queen extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9813;';

    public function getMoves(): array
    {

        $aMoves = [
            0 => [],
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => []
        ];;

        for ($i = 1; $i < 8; $i++) {

            // Diag
            $aMoves[0][] = [$this->x + $i, $this->y + $i];
            $aMoves[1][] = [$this->x - $i, $this->y - $i];
            $aMoves[2][] = [$this->x + $i, $this->y - $i];
            $aMoves[3][] = [$this->x - $i, $this->y + $i];

            //// Horizontal et vertical
            $aMoves[4][] = [$this->x, $this->y + $i];
            $aMoves[5][] = [$this->x - $i, $this->y];
            $aMoves[6][] = [$this->x + $i, $this->y];
            $aMoves[7][] = [$this->x, $this->y - $i];
        }
        return $aMoves;
        
    }
}