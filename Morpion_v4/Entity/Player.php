<?php
namespace Entity;

/**
 * final = empêche l'héritage de la classe (non obligatoire)
 */
final class Player
{
    // Propriétés / Attributs
    /** @var string */
    private string $name;

    /** @var string */
    private string $team;
        
    /**
     * __construct
     *
     * @param  string $sName
     * @param  string $sTeam
     * @return void
     */
    public function __construct(string $sName, string $sTeam)
    {
        $this->name = $sName;
        $this->team = $sTeam;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    // Comportements / Fonctions

    /**
     * Get the value of team
     */ 
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set the value of team
     *
     * @return  self
     */ 
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
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
}