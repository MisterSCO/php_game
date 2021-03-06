<?php
namespace Model;

abstract class Monster
{
    use Positionable;


    /** @var int */
    protected int $health;


    /** @var int */
    protected int $strength;
    
    /**
     * @return void
     */
    public function __construct()
    {
        
    }

    public function getRetaliation() : int
    {
        if ($this->isDead()) {
            return 0;
        }
        return (rand(0,1)) ? $this->strength : 0;
    }

    public function isDead(): bool
    {
        return $this->health <= 0;
    }

    public function getMoves(): array
    {
        return [];
    }

    /**
     * Get the value of health
     */ 
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set the value of health
     *
     * @return  self
     */ 
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get the value of strength
     */ 
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set the value of strength
     *
     * @return  self
     */ 
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }
}