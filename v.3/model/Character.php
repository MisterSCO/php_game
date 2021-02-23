<?php


abstract class Character
{

    /* 
        Propriétés/Attributs
        Convention de code : camelCase
    */

    protected $name;
    protected $health;
    protected $strength;

    
    /**
     * hit
     *
     * @param  Character $playerB
     * 
     */
    public function hit(Character $playerB)
    {
        echo $this . ' dit : A l\'attaque!!!!!' . PHP_EOL;
        $playerB->setHealth($playerB->getHealth() - $this->getStrength() );
    }
    
    
    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this -> name;
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
