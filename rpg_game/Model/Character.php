<?php
namespace Model;


abstract class Character extends Pawn
{

    /* 
        Propriétés/Attributs
        Convention de code : camelCase
    */

    /** @var string */
    protected string $name;

    /** @var int */
    protected int $health;

    /** @var int */
    protected int $strength;


    /**
     * construct
     *
     * @param  mixed $sName
     * @return void
     */
    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }

    public function getMoves(): array
    {

        $aMoves = [];

        // Horizontal et vertical
        $aMoves[] = [$this->x, $this->y - 1];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];

        return  $aMoves;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
