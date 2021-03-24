<?php
namespace Model;

final class Dragon extends Monster
{
    use Positionable;

    /**@const int */
    public const NB_MONSTERS = 1;

    /**@const int */
    public const MAX_HEALTH = 200;

    /**@const string */
    protected const SYMBOL = '🐉';

    /** @var int */
    protected int $health;

    /** @var int */
    protected int $strength;
    
    /**
     * @return void
     */
    public function __construct()
    {
        $this->health = self::MAX_HEALTH;
        $this->strength = 50;
    }
    
    /**
     * @return string
     */
    public function __toString() : string
    {
        return self::SYMBOL;
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