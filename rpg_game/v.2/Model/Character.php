<?php
namespace Model;

/*
 * Référentiel de la classe Character
 * Conventions de code : PascalCase
 * abstract = non instanciable (non obligatoire)
 */
abstract class Character extends Pawn
{
    /** @var string */
    protected string $name;

    /** @var int */
    protected int $MaxHealth;

    /** @var int */
    protected int $health;

    /** @var int */
    protected int $strength;
    
    /**
     * @param string $sName
     *
     * @return void
     */
    public function __construct(string $sName)
    {
        parent::__construct();
        
        $this->name = $sName;
    }

    public function getMoves(): array
    {
        $aMoves = [];
        
        // Carré
        $aMoves[] = [$this->x + 1, $this->y];
        $aMoves[] = [$this->x - 1, $this->y];
        $aMoves[] = [$this->x, $this->y + 1];
        $aMoves[] = [$this->x, $this->y - 1];

        return $aMoves;
    }

    
    /**
     * Get /*
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set /*
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

    /**
     * Get the value of MaxHealth
     */ 
    public function getMaxHealth()
    {
        return $this->MaxHealth;
    }

    /**
     * Set the value of MaxHealth
     *
     * @return  self
     */ 
    public function setMaxHealth($MaxHealth)
    {
        $this->MaxHealth = $MaxHealth;

        return $this;
    }
}