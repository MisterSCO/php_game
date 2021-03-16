<?php
namespace Model\Chess;

final class Bishop extends \Model\Pawn 
{
    /**@var string */
    protected const SYMBOL = '&#9815;';

    public function getMoves(): array
    {
        // On prepare les groupement de coordonnées
        $aMoves = [
            0 => [],
            1 => [],
            2 => [],
            3 => []
        ];

        // Dirrection
        for ($i = 1; $i < 8; $i++) {
            $aMoves[0][] = [$this->x + $i, $this->y + $i];
            $aMoves[1][] = [$this->x - $i, $this->y - $i];
            $aMoves[2][] = [$this->x + $i, $this->y - $i];
            $aMoves[3][] = [$this->x - $i, $this->y + $i];
        }
        return $aMoves;
    }
}