<?php
namespace Model;

class Mob
{
    use Positionable;


    public const NB_MONSTERS = 10;

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