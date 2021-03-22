<?php
namespace Model;

class Mob
{
    use Positionable;

    /**@var string */
    protected const SYMBOL = '🧟';


    public function __toString(): string
    {
        return self::SYMBOL;
    }

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