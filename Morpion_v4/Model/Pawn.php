<?php
namespace Model;

//use \Entity\Player;

final class Pawn 
{
    /** @var string */
    private string $symbol;

    /** @var Player */
    private \Entity\Player $player;
        
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