<?php
namespace Model\Chess;

use Model\ChessGame;

final class Peon extends \Model\Pawn 
{
    

    /**@var string */
    protected const SYMBOL = '&#9817;';


    public function getMoves(): array
    {

        switch ($this->getPlayer()->getTeam()) {
            case \Model\ChessGame::TEAMS[0] :
                $aMoves[0][] = [$this->x, $this->y - 1];
                if ($this->y === 6) {
                    $aMoves[0][] = [$this->x, $this->y - 2];
                }
                break;

            case \Model\ChessGame::TEAMS[1]:
                $aMoves[0][] = [$this->x, $this->y + 1];
                if ($this->y === 1) {
                    $aMoves[0][] = [$this->x, $this->y + 2];
                }
                break;
            
        }
        return $aMoves;
    }
}