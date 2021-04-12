<?php
namespace Model;

/*
 * Référentiel de la classe Character
 * Conventions de code : PascalCase
 * abstract = non instanciable (non obligatoire)
 */
abstract class Character extends Pawn
{
    /**@var string */
    public const NAME = 'Personnage';

    /** @var string */
    protected string $name;

    /** @var int */
    protected int $maxHealth;
    
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
        return [];
    }

    public function getAttacks(): array
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

    public function hit(Monster $oMonster)
    {
        if ($this->isDead()) {
            return false;
        }

        $oMonster->setHealth($oMonster->getHealth() - $this->strength);
        
        // Riposte du monstre
        $this->health -= $oMonster->getRetaliation();
    }
    
    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->health <= 0;
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
     * Get the value of maxHealth
     */ 
    public function getMaxHealth()
    {
        return $this->maxHealth;
    }

    /**
     * Set the value of maxHealth
     *
     * @return  self
     */ 
    public function setMaxHealth($maxHealth)
    {
        $this->maxHealth = $maxHealth;

        return $this;
    }
}