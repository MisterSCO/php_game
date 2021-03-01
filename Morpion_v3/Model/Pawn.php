<?php
namespace Model;

final class Pawn
{
    /** @var string */
    private $symbol;

    private $player;



    public function __toString()
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
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

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
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }
}