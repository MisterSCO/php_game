<?php


final class Game 
{

    const SIZE_X = 3;
    const SIZE_Y = 3;

    private array $board;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->createBoard();
    }

    /**
     * isValidXY
     *
     * @param  int $x
     * @param  int $y
     * @return bool
     */
    public function isValidXY(int $x, int $y): bool
    {
        return ($x >= 0 && $x < self::SIZE_X  && $y >= 0 && $y < self::SIZE_Y);
    }

    /**
     * displayBoard
     *
     * @return void
     */
    public function displayBoard(): void
    {
        for ($y = 0; $y < self::SIZE_Y; $y++) {
            for ($x = 0; $x < self::SIZE_X; $x++) {
                echo '[ ' . $this -> board[$y][$x] . ' ] ';
            }
            echo PHP_EOL;
            echo PHP_EOL;
        }
    }

    /**
     * creatboard
     *
     * @return array
     */
    private function createBoard()
    {
        $board = [];
        for ($y = 0; $y < self::SIZE_Y; $y++) {
            
            $board[$y] = [];
            for ($x = 0; $x < self::SIZE_X; $x++) 
            {
                $board[$y][$x] = '';
            }
        }
        $this->board = $board;
    }

    

    /**
     * Get the value of board
     */ 
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Set the value of board
     *
     * @return  self
     */ 
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }
}