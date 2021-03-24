<?php
namespace Model;

final class Spider extends Monster
{
    use Positionable;

    /**@var int */
    public const NB_MONSTERS = 10;

    /**@const int */
    public const MAX_HEALTH = 10;

    /**@var string */
    protected const SYMBOL = '🕸️';

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
        $this->strength = 10;
    }
    
    /**
     * @return string
     */
    public function __toString() : string
    {
        return self::SYMBOL;
    }

    public function getMoves(): array
    {
        $aMoves = [];

        // Diag
        $aMoves[] = [$this->x - 1, $this->y - 1];
        $aMoves[] = [$this->x - 1, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y - 1];
        $aMoves[] = [$this->x + 1, $this->y + 1];

        // Carré
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x, $this->y - 1];

        return $aMoves;
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