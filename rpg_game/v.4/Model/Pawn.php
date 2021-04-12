<?php
namespace Model;

//use \Entity\Player;

class Pawn 
{
    use Positionable;

    /**@var string */
    protected const SYMBOL = '';

    /** @var string */
    protected string $symbol;

    /** @var Player */
    protected \Entity\Player $player;

    public function __construct()
    {
        $this->symbol = static::SYMBOL;
    }
    
    /**
     * @return array
     */
    public function getMoves() : array
    {
        return [];
    }
        
    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->symbol;
    }

    /**
     * Get the value of symbol
     */ 
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set the value of symbol
     *
     * @return  self
     */ 
    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
        
        // fluent setter
        return $this;
    }

    /**
     * Get the value of player
     */ 
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set the value of player
     *
     * @return  self
     */ 
    public function setPlayer(\Entity\Player $player)
    {
        $this->player = $player;

        return $this;
    }
}