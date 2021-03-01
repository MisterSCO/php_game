<?php 
namespace Model;

final class ChessGame extends AbstractGame
{
    // On défini les équipes
    public const TEAMS = ['Whites','Blacks'];

    // On défini la dimensions
    protected const SIZE_X = 8;
    protected const SIZE_Y = 8;
    
    function __construct()
    {
        parent::__construct();
        $this->fillBoard();
    }

    protected function playerAction(\Entity\Player $oPlayer): void
    {
        // TODO
    }

    protected function isWinUltraOptimized(): bool
    {
        return false;
    }



    private function fillBoard() : void
    {

        $a = [0,7];
        foreach ($a as $i) {
            $this->board[$i][0] = new  Chess\Rook;
            $this->board[$i][1] = new  Chess\Knight;
            $this->board[$i][2] = new  Chess\Bishop;
            $this->board[$i][3] = new  Chess\Queen;
            $this->board[$i][4] = new  Chess\King;
            $this->board[$i][5] = new  Chess\Bishop;
            $this->board[$i][6] = new  Chess\Knight;
            $this->board[$i][7] = new  Chess\Rook;
        }

        //Peons
        for ($i=0; $i < self::SIZE_X; $i++) {
            $this->board[6][$i] = new  Chess\Peon;
            $this->board[1][$i] = new  Chess\Peon;
        }
    }
}